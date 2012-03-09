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

#Roundcube
wget http://chili.kload.fr/attachments/download/22/roundcubemail-0.7.1.tar.gz
tar -xvzf roundcubemail-0.7.1.tar.gz
mv roundcubemail-0.7.1/* /var/www/yunohost/webmail/ 
echo -e "[suhosin]\nsuhosin.session.encrypt = Off" >> /etc/php5/apache2/php.ini
ROUNDCUBE=$(randpass 10 0)
mysql -e "create database roundcubemail;"
mysql -e "GRANT ALL PRIVILEGES ON roundcubemail.* to 'roundcube'@'localhost' IDENTIFIED BY '$ROUNDCUBE';"
deskey=$(dd if=/dev/urandom bs=1 count=200 2> /dev/null | tr -c -d '[A-Za-z0-9]' | sed -n 's/\(.\{24\}\).*/\1/p')
sed -i "s/changethedeskey/$deskey/g" config/roundcube/main.inc.php
mysql roundcubemail < /var/www/yunohost/webmail/SQL/mysql.initial.sql
sed -i "s/pass/$ROUNDCUBE/g" config/roundcube/db.inc.php
wget http://chili.kload.fr/attachments/download/25/roundcube-0.7.1-bundle-v1.6.zip
unzip roundcube-0.7.1-bundle-v1.6.zip
cp -r trunk/plugins/logout_redirect/ /var/www/yunohost/webmail/plugins/
cp -r  trunk/plugins/calendar/ /var/www/yunohost/webmail/plugins/
cp -r  trunk/plugins/qtip/ /var/www/yunohost/webmail/plugins/
cp -r  trunk/plugins/http_auth/ /var/www/yunohost/webmail/plugins/
mysql roundcubemail < /var/www/yunohost/webmail/plugins/calendar/SQL/mysql.sql
cp config/roundcube/* /var/www/yunohost/webmail/config/
cp -r config/roundcube/plugins/* /var/www/yunohost/webmail/plugins/
chown -R www-data:www-data /var/www/yunohost/webmail/
rm -Rf /var/www/yunohost/webmail/installer/

#Jappix
wget http://chili.kload.fr/attachments/download/23/jappix-spaco-0.9.zip
unzip jappix-spaco-0.9.zip
mv jappix/* /var/www/yunohost/chat/
cp -r config/jappix/* /var/www/yunohost/chat/store/
chmod 777 /var/www/yunohost/chat/store/*
chown -R www-data:www-data /var/www/yunohost/chat/

#Tiny Tiny RSS
wget http://chili.kload.fr/attachments/download/24/tt-rss-1.5.10.tar.gz
tar -xvzf tt-rss-1.5.10.tar.gz
mv tt-rss-1.5.10/* /var/www/yunohost/rss/
TTRSS=$(randpass 10 0)
mysql -e "create database ttrss;"
mysql -e "GRANT ALL PRIVILEGES ON ttrss.* to 'ttrss'@'localhost' IDENTIFIED BY '$TTRSS';"
mysql ttrss < /var/www/yunohost/rss/schema/ttrss_schema_mysql.sql
sed -i "s/passmysql/$TTRSS/g" config/ttrss/config.php
cp config/ttrss/config.php /var/www/yunohost/rss/
chown -R www-data:www-data /var/www/yunohost/rss/

#Radicale
pip install radicale
mkdir /var/www/.config/
chown www-data:www-data /var/www/.config/
cp config/radicale/radicale.wsgi /var/www/yunohost/sync/
chown -R www-data:www-data /var/www/yunohost/sync/

#Iptables
cp config/autre/iptables /etc/init.d/
update-rc.d iptables defaults

#Hosts
cp config/autre/hosts /etc/

#Config yunohost
mkdir /etc/yunohost/
cp config/update/* /etc/yunohost/
