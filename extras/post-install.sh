#!/bin/bash

DC=$(slapcat | cut -d" " -f2 | grep ^dc -m1)
DOMAIN=$(hostname -d)

HOSTNAME=$(hostname -f)

function randpass() {
  [ "$2" == "0" ] && CHAR="[:alnum:]" || CHAR="[:graph:]"
    cat /dev/urandom | tr -cd "$CHAR" | head -c ${1:-32}
    echo
}

cd /root/

tar -xvzf config.tar.gz

find ./config -type f -exec sed -i "s/yunohost.org/$DOMAIN/g" {} \;
find ./config -type f -exec sed -i "s/dc\=yunohost\,dc\=org/$DC/g" {} \;

#SSL
openssl req -x509 -new -config /root/config/ssl/yunoCA/openssl.cnf -days 3650 -out /root/config/ssl/yunoCA/ca/cacert.pem -keyout /root/config/ssl/yunoCA/ca/cakey.pem -nodes -batch
openssl req -new -config /root/config/ssl/yunoCA/openssl.cnf -days 730 -out /root/config/ssl/yunoCA/certs/yunohost_csr.pem -keyout /root/config/ssl/yunoCA/certs/yunohost_key.pem -nodes -batch
openssl ca -config /root/config/ssl/yunoCA/openssl.cnf -days 730 -in /root/config/ssl/yunoCA/certs/yunohost_csr.pem -out /root/config/ssl/yunoCA/certs/yunohost_crt.pem -batch
cp config/ssl/yunoCA/ca/cacert.pem /etc/ssl/certs/ca-yunohost_crt.pem
cp config/ssl/yunoCA/certs/yunohost_key.pem /etc/ssl/private/
cp config/ssl/yunoCA/newcerts/01.pem /etc/ssl/certs/yunohost_crt.pem

#Apache2
a2enmod rewrite ssl perl headers proxy_http authnz_ldap 
mkdir -p /var/www/yunohost/{chat,rss,webmail,www,admin,sync}
cp config/apache2/{chat,handler,manager,portal,rss,webmail,www,admin,bind,sync} /etc/apache2/sites-available/
cp config/apache2/ports.conf /etc/apache2/
a2ensite chat handler manager portal rss webmail www admin bind sync
a2dissite default  default-ssl

#OpenLDAP
cp config/slapd/slapd.conf /etc/ldap/
chown root:openldap /etc/ldap/slapd.conf
cp config/slapd/slapd /etc/default/
cp config/slapd/schema/mailserver.schema /etc/ldap/schema/

#Postfix
cp config/postfix/* /etc/postfix/

#Dovecot
adduser --system --ingroup mail --uid 500 vmail
cp -r config/dovecot/* /etc/dovecot/
chown -R vmail:mail /etc/dovecot/global_script/
chmod -R 770 /etc/dovecot/global_script/
sievec /etc/dovecot/global_script/

#Ejabberd
cp config/ejabberd/ejabberd.cfg /etc/ejabberd/
chown ejabberd:ejabberd /etc/ejabberd/ejabberd.cfg
cat /etc/ssl/private/yunohost_key.pem > /etc/ejabberd/ejabberd.pem
cat /etc/ssl/certs/yunohost_crt.pem >> /etc/ejabberd/ejabberd.pem
chown root::ejabberd /etc/ejabberd/ejabberd.pem

#LemonLDAP
cp config/lemonldap/lemonldap-ng.ini /etc/lemonldap-ng/
chgrp www-data /etc/lemonldap-ng/lemonldap-ng.ini
cp config/lemonldap/lmConf-1 /var/lib/lemonldap-ng/conf/lmConf-1
chown www-data:www-data /var/lib/lemonldap-ng/conf/lmConf-1

#Amavis
cp config/amavis/conf.d/* /etc/amavis/conf.d/
adduser clamav amavis
cp config/spamassassin/spamassassin /etc/default/
sa-update
cp config/spamassassin/local.cf /etc/spamassassin/
su - amavis -c "razor-admin -d --create"
su - amavis -c "razor-admin -register"
su - amavis -c "razor-admin -discover"
su - amavis -c "pyzor discover"

#Mysql
/etc/init.d/mysql start

#Iptables
cp config/autre/iptables /etc/init.d/
update-rc.d iptables defaults

#Hosts
cp config/autre/hosts /etc/

#Config yunohost
mkdir /etc/yunohost/
cp config/update/* /etc/yunohost/
