# Magento base theme

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
