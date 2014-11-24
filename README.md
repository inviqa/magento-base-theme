# Magento base theme

The aim of the theme is to create a starting point for all projects whether they are mobile, responsive or desktop redesign projects.

This would reduce the amount of time it takes to set up a new theme for a project but reducing the time spent optimising a enterprise/default magento theme which usually takes at least a day. This would also help in standardising the structure and frontend code structure of projects, improving the consistency of code and improve efficiency when woking on multiple projects.

## Wiki

https://ibuildings.jira.com/wiki/display/SESSIONMX/MAST-++Magento+Session+Theme

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
    cp ../mast-repo/gruntfile.js ../mast-repo/package.json .
    cp -r ../mast-repo/public/skin/frontend/session/ ./public/skin/frontend/
    cp -r ../mast-repo/public/app/design/frontend/session ./public/app/design/frontend/

### In the browser

In your browser of choice, your VM will be available at http://mast.dev

### Grunt

After you first boot your VM, in `/public/skin/frontend/session/default` run `npm install`. After this, you can run:

* `grunt watch` : the usual watch task.
* `grunt build` : includes tasks to prepare for production including uglify and imagemin.

## Making changes

Currently there is no good way of pushing updates to this repo while using the hobo seed as your local environment. It is recommended that you test on your seed VM, then manually copy files over to your `mast-repo` directory where you can commit and push changes.
