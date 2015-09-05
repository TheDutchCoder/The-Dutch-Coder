#!/bin/bash

#add dokku remote as well dokku soshal::deploy-url $app_name
# function setup_dokku()
# {
#   ssh-keygen -t rsa -N "" -f ~/.ssh/"$app_name"_rsa
#   #figure out how to ssh to server without storing private key in repo
#   cat ~/.ssh/id_rsa.pub | vagrant ssh box2 -- sudo sshcommand acl-add dokku ${USER}
# }

function get_app_name()
{
        echo "Please provide an app name"
        read app_name

        if [ -z $app_name ]; then
                echo "App name cannot be blank."
                get_app_name
        fi
}

function add_origin_remote_url()
{
  read origin_url
  if [ -z $origin_url ]; then
            echo "Origin url cannot be blank."
            add_origin_remote_url
    fi

    #consider checking for git@
    if [[ $origin_url == *"https"* ]]
  then
    echo "Please provide the ssh remote url not the https";
    add_origin_remote_url
  fi

  git remote add origin $origin_url
}

function remote_repo()
{
  echo "Do you have an existing remote repo[y/n]"
  read existing_remote_repo

  case $existing_remote_repo in
    "") echo "please submit [y/n]"
      remote_repo
      ;;
    y)  echo "Please provide the existing remote url somehting like(git@bitbucket.org:soshalgroup/project)"
      add_origin_remote_url
      ;;
    n)  echo "no remote repo" 
      ;;
  esac  
}

function new_project()
{
  if [ -d "/var/www" ]; then
    cd /var/www
    fi

  if [ -d ".git" ]; then
    #might not need sudo
    sudo rm -rf .git
  fi  

  git flow init -d
  remote_repo

}

function setup_git_repo()
{
  echo "Is this a new project[y/n]"
  read is_new_project

  case $is_new_project in
    "") echo "please submit [y/n]"
      setup_git_repo
      ;;
    y)  echo "new project"
      new_project
      ;;
    n)  echo "not new project" 
      ;;
  esac
}

function hosts_setup()
{
  machine_ip="$(/sbin/ifconfig eth1 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}')"
  echo "please add the following line to the bottom of your machines hosts file"
  echo "$machine_ip      dev.$app_name.ca"
  # >> /etc/hosts
}

function setup()
{
  get_app_name
  setup_git_repo  
  hosts_setup
}

function clean_up()
{
  echo "Would you like to remove the setup script [y/n]"
  read to_remove

  case $to_remove in
    "") clean_up
      ;;
    y)  echo "Setup script Removed"
      rm setup-1.sh
      ;;
    n) 
      ;;
  esac
}


setup
clean_up