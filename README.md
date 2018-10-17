**GenIE-CMS Development**  
This is the Development and the latest version of GenIE-CMS. Our main goal is to add admin interface where users can easily create database plus integrate different types of data, create new pages and menus, configure tools and changing website layout by using Themes.

As we mentioned in [this](https://plantgenie.gitbook.io/meeting/diary/october-2018#15th-of-october) document, we have two ways to start GenIE-CMS:

1.) [Using the Docker image](https://github.com/irusri/Docker4GenIECMS)   
2.) [Using standalone webserver](https://geniecms.readthedocs.io/en/latest/installation_updates.html)

However, we need to have an error free CMS to running in the backend to compatible with both above situations. For the development purpose I would like to use the docker container, commit and push changes to genie.git and simply remove the container.  

**How can we make GenIE-CMS development environment with Docker?**
<pre>
# Please comment the supporting_files/run.sh line to avoid download the geniecms.git  
git clone https://github.com/irusri/docker4geniecms.git  
cd docker4geniecms  
git submodule add -f https://github.com/irusri/genie.git  
docker build -t genie -f ./Dockerfile .  
docker run --rm -i -t -p "80:80" -p "3308:3306" -v ${PWD}/genie:/app -v ${PWD}/mysql:/var/lib/mysql -e MYSQL_ADMIN_PASS="mypass" --name genie genie  
cd genie 
</pre>

When we need to commit changes, please go to `cd docker4geniecms/genie folder. Never commit from `docker4geniecms` folder. Then it will add genie as a submodule. Incase this happens please use `docker4geniecms $ git rm geniecms`. You can access MySQL using `mysql -u admin -pmypass -h localhost -P 3308` or using [phpMyAdmin](http://localhost/phpmyadmin). Some useful docker commands are as follows.
<pre>
# Must be run first because images are attached to containers
docker rm -f $(docker ps -a -q)
# Delete every Docker images
docker rmi -f $(docker images -q)
# To see docker process
docker ps -l 
# To see or remove all volumes
docker volume ls/prune
# To run bash inside the running docker container
docker exec -it 890fa15eeef6126b668f4b0fcb7a38b33eaff0 /bin/bash
or
docker attach 890fa15eeef6126b668f4b0fcb7a38b33eaff0
</pre>

Now we can start the real development and push changes into genie.
