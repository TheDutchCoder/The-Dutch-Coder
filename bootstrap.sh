#!/usr/bin/env bash

echo "--- Increase php max upload ---"
sudo sed -i "s/post_max_size.*/post_max_size = 30M/g" /etc/php5/apache2/php.ini
sudo sed -i "s/post_max_size.*/post_max_size = 30M/g" /etc/php5/cli/php.ini 
sudo sed -i "s/upload_max_filesize.*/upload_max_filesize = 20M/g" /etc/php5/apache2/php.ini
sudo sed -i "s/upload_max_filesize.*/upload_max_filesize = 20M/g" /etc/php5/cli/php.ini

echo "--- Getting the latest package updates and installing unzip ---"
sudo apt-get update
sudo apt-get install unzip

echo "--- Installing the latest RVM and gems"
sudo \curl -L https://get.rvm.io | bash -s stable --ruby
echo "PATH="$GEM_HOME/bin:$HOME/.rvm/bin:$PATH" # Add RVM to PATH for scripting" >> /home/vagrant/.bash_profile
echo "[ -s ${HOME}/.rvm/scripts/rvm ] && source ${HOME}/.rvm/scripts/rvm" >> /home/vagrant/.bash_profile
gem install scss_lint

echo "--- Installing wp-cli ---"
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
sudo chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wpcli

echo "--- Downloading Latest Wordpress ---"
sudo -u vagrant -i -- wpcli core download --path="/var/www/public/"

#TODO figure out why exit gets added to the file. Figure out the correct way to use --extra-php instead of useing search and replace
echo "--- Create wp-config file ---"
sudo -u vagrant -i -- wpcli core config --dbname=$1 --dbuser=root --dbpass=root --path="/var/www/public/"
sed -i 's/exit/define('FS_METHOD', 'direct');/g' /var/www/public/wp-config.php

echo "--- Creating Wordpress Database ---"
sudo -u vagrant -i -- wpcli db create --path="/var/www/public/"

echo "--- Creating Wordpress Database Tables ---"
sudo -u vagrant -i -- wpcli core install --path="/var/www/public/" --url='dev.'"$1"'.ca' --title="$1" --admin_user="soshal" --admin_password="hulkh0gan" --admin_email="it.ops@soshal.ca"

if [ ! -d "/var/www/public/wp-content/themes/$1/" ]; then 
	
	echo "--- Remove old themes ---"
	sudo rm -rfv /var/www/public/wp-content/themes/*

	echo "--- Remove old plugins ---"
	sudo rm -rfv /var/www/public/wp-content/plugins/*

	echo "--- Installing Wordpress default plugins ---"
	
	base_plugins=(
	 "wordpress-seo"
	 "google-analytics-dashboard-for-wp"
	)

	pro_plugins=(
		"wpml-string-translation.2.1.4.zip"
		"sitepress-multilingual-cms.3.1.9.7.zip"
		"ithemes-security-pro-1.14.20.zip"
		"wp-migrate-db-pro-1.4.7.zip"
		"wp-migrate-db-pro-cli-1.1.zip"
		"wp-migrate-db-pro-media-files-1.3.1.zip"
		"advanced-custom-fields-pro.zip"
	)

	for i in "${!base_plugins[@]}"
	do
		sudo -u vagrant -i -- wpcli plugin install "${base_plugins[$i]}" --path="/var/www/public/"
	done

	for i in "${!pro_plugins[@]}"
	do
		curl -L https://s3.amazonaws.com/soshal-resources/wordpress-plugins/"${pro_plugins[$i]}" > /var/www/public/wp-content/plugins/"${pro_plugins[$i]}"
		sudo unzip -o /var/www/public/wp-content/plugins/"${pro_plugins[$i]}" -d /var/www/public/wp-content/plugins
		sudo rm /var/www/public/wp-content/plugins/"${pro_plugins[$i]}"
	done

	sudo -u vagrant -i -- wpcli plugin activate advanced-custom-fields-pro --path="/var/www/public/"
	sudo -u vagrant -i -- wpcli plugin activate wp-migrate-db-pro --path="/var/www/public/"
	sudo -u vagrant -i -- wpcli plugin activate wp-migrate-db-pro-cli --path="/var/www/public/"
	sudo -u vagrant -i -- wpcli plugin activate wp-migrate-db-pro-media-files --path="/var/www/public/"
	sudo -u vagrant -i -- wpcli plugin update --all --path="/var/www/public/"

	echo "--- installing soshal wordpress base theme ---"
	curl -L https://s3.amazonaws.com/soshal-resources/soshal-theme/soshal.wp_latest.zip > /var/www/public/soshal-theme.zip
	sudo unzip -o /var/www/public/soshal-theme.zip -d /var/www/public
	sudo rm /var/www/public/soshal-theme.zip
	sudo mv /var/www/public/wp-content/themes/soshal_theme /var/www/public/wp-content/themes/$1

	echo "--- Activate soshal theme ---"
	sed -i "s/soshal_theme/$1/g" /var/www/public/wp-content/themes/$1/style.css
	sed -i "s/soshal_theme/$1/g" /var/www/public/wp-content/themes/$1/img/favicons/manifest.json
	sed -i "s/soshal_theme/$1/g" /var/www/public/package.json
	sed -i "s/repo_url/$1/g" /var/www/public/package.json
	sed -i "s/soshal_theme/$1/g" /var/www/public/.gitignore
	sudo -u vagrant -i -- wpcli theme activate $1 --path="/var/www/public/"

	echo "--- Adding SASS framework ---"
	sudo mkdir /var/www/public/wp-content/themes/$1/sass
	curl -L https://s3.amazonaws.com/soshal-resources/soshal-sass/soshal.css_latest.zip > /var/www/public/wp-content/themes/$1/sass/soshal-sass-framework.zip
	sudo unzip -o /var/www/public/wp-content/themes/$1/sass/soshal-sass-framework.zip -d /var/www/public/wp-content/themes/$1/sass/
	sudo rm /var/www/public/wp-content/themes/$1/sass/soshal-sass-framework.zip
fi

echo "####################################################################"
echo "         _             _          _            _           _        "
echo "        /\ \     _    /\ \       /\ \         /\ \        / /\      "
echo "       /  \ \   /\_\ /  \ \      \_\ \       /  \ \      / /  \     "
echo "      / /\ \ \_/ / // /\ \ \     /\__ \     / /\ \ \    / / /\ \__  "
echo "     / / /\ \___/ // / /\ \ \   / /_ \ \   / / /\ \_\  / / /\ \___\ "
echo "    / / /  \/____// / /  \ \_\ / / /\ \ \ / /_/_ \/_/  \ \ \ \/___/ "
echo "   / / /    / / // / /   / / // / /  \/_// /____/\      \ \ \       "
echo "  / / /    / / // / /   / / // / /      / /\____\/  _    \ \ \      "
echo " / / /    / / // / /___/ / // / /      / / /______ /_/\__/ / /      "
echo "/ / /    / / // / /____\/ //_/ /      / / /_______\\ \/___/ /       "
echo "\/_/     \/_/ \/_________/ \_\/       \/__________/ \_____\/        "
echo "####################################################################"

machine_ip="$(/sbin/ifconfig eth1 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}')"; 
echo "Please add this line to the end of you /etc/hosts file on your local machine: $machine_ip"      'dev.'"$1"'.ca';
echo "Please ssh into your vagrant machine with 'vagrant ssh' then run 'sudo npm install' from the /var/www/public directory to ensure that all of the node packages are installed."
