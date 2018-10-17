**GenIE-CMS Development**  
This is the Development and the latest version of GenIE-CMS. Our main goal is to add admin interface where users can easily create database plus integrate different types of data, create new pages and menus, configure tools and changing website layout by using Themes.

As we mentioned in [this](https://plantgenie.gitbook.io/meeting/diary/october-2018#15th-of-october) document, we have two ways to start GenIE-CMS:

1.) [Using the Docker image](https://github.com/irusri/Docker4GenIECMS)   
2.) [Using standalone webserver](https://geniecms.readthedocs.io/en/latest/installation_updates.html)

However, we need to have an error free CMS to running in the backend to compatible with both above situations. For the development purpose I would like to use the docker container, commit and push changes to genie.git and simply remove the container.  

**How can we make a development environment?**
<pre>
#Please comment the supporting_files/run.sh line to avoid download the geniecms.git  
git clone https://github.com/irusri/docker4geniecms.git  
cd docker4geniecms  
git submodule add -f https://github.com/irusri/genie.git  
docker build -t genie -f ./Dockerfile .  
docker run --rm -i -t -p "80:80" -p "3308:3306" -v ${PWD}/genie:/app -v ${PWD}/mysql:/var/lib/mysql -e MYSQL_ADMIN_PASS="mypass" --name genie genie  
cd genie 
</pre>

When we need to commit the changes please go to cd docker4geniecms/genie folder. Never commit from `docker4geniecms` folder. Then it will add genie as a submodule. Incase this happens please use `docker4geniecms $ git rm geniecms`. You can access MySQL using `mysql -u admin -pmypass -h localhost -P 3308` or using [phpmyadmin](http://localhost/phpmyadmin).
