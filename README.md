# Magento base theme

[Wiki page](https://ibuildings.jira.com/wiki/display/SESSIONMX/MAST-++Magento+Session+Theme)

The aim of the theme is to create a starting point for all projects whether they are mobile, responsive or desktop redesign projects.

This would reduce the amount of time it takes to set up a new theme for a project but reducing the time spent optimising a enterprise/default magento theme which usually takes at least a day. This would also help in standardising the structure and frontend code structure of projects, improving the consistency of code and improve efficiency when woking on multiple projects.

## Getting set up

### Hobo seed

There is not currently a dedicated VM for MAST changes. In order to develop and test changes, start by setting up a magento seed VM:

    cd ~/Sites
    hobo seed plant mast --seed=magento

When prompted:

    git@github.com:inviqa/magento-base-theme.git
    Magento edition: 1 (enterprise)
    Magento version: 1 (latest)

When this is complete, boot the VM:

    hobo vm up

### Copy over the MAST files

Clone the MAST repo into another folder:

    git clone git@github.com:inviqa/magento-base-theme.git mast-repo

Copy the relevant files and directories into your seed VM:

    cd ~/Sites/mast
    cp -r ../mast-repo/public/skin/frontend/session/ ./public/skin/frontend/
    cp -r ../mast-repo/public/app/design/frontend/session ./public/app/design/frontend/

### In the browser

In your browser of choice, your VM will be available at http://mast.dev

## Making changes

Currently there is no good way of pushing updates to this repo while using the hobo seed as your local environment. It is recommended that you test on your seed VM, then manually copy files over to your `mast-repo` directory where you can commit and push changes.

## Other information

### Grunt and Bower

After you first boot your VM:

    cd /public/skin/frontend/session/default
    npm install
    bower install

After this, you can run `gulp` and it will:

* Compile Sass
* Build scripts
* Opitimise images
* Start a [BrowserSync](http://www.browsersync.io/) server, with watches on styles, js and images 

### Theme fallback

For 1.13 the `session/default` theme will fall back to `base/default`. To change this, we have used the *Aoe_DesignFallback* module. Read more about it on [Fabrizio Branca's blog](http://fbrnc.net/blog/2012/03/custom-design-fallbacks-in-magento).

In 1.14 this is already set up for you using [this method](http://alanstorm.com/magento_parent_child_themes) and can be modified in the following file:

    app/design/frontend/session/default/etc/theme.xml

### Database / setup scripts

A default database or setup scripts with common settings will be added to this repo in the future.
