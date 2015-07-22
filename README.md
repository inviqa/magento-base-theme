# Magento base theme

[Wiki page](https://ibuildings.jira.com/wiki/display/SESSIONMX/MAST-++Magento+Session+Theme)

## Goals

The aims of MAST are to:

* reduce set up time on new projects.
* standardise the structure and tooling for frontend work.
* improve the consistency of code to improve quality / efficiency, especially when working on multiple projects.
* provide solutions to issues common to most projects.
* provide a demonstrable theme to share with potential clients.
* eventually release as an open sourced Magento theme.

## Getting set up

In the root directory:

    hobo vm up

In your browser of choice, your VM will be available at [http://mast.dev](http://mast.dev).

## Using it in a project

1 - Open the project's composer.json file.
2 - Add the `inviqa/magento-base-theme` as a project's dependency. 
```
  "require": {
    "inviqa/magento-base-theme": "dev-master"
  },
  "repositories": [
    {
      "type":"vcs",
      "url": "git@github.com:inviqa/magento-base-theme.git"
    }
  ],
```
3 - In the `composer.json` file, map the items you want to copy across during project's initial bootstrap:
```
  "extra": {
    "path-mappings": {
      "tools/pattern-lab": {
        "package":"inviqa/magento-base-theme",
        "file": "tools/pattern-lab"
      },
      "public/skin/frontend": {
        "package":"inviqa/magento-base-theme",
        "file": "public/skin/frontend"
      }
    }
  },
```
4 - Add the script to the project's `composer.json` file so to trigger the copy mechanism:
```
  "scripts": {
    "post-install-cmd": "Inviqa\\Mast\\Installer::postPackageInstall"
  }
```
5 - Run `composer install` on the project's directory (might be handled by some other tools, like i.e. hobo with `hobo vm up`)

## Tools and settings

### Gulp and Bower

You should have `gulp` installed globally on your machine.

After you first boot your VM:

    cd /public/skin/frontend/session/default
    npm install
    bower install

After this, you can run `gulp` and it will:

* Compile SCSS to CSS
* Build scripts
* Optimise images
* Generate the style guide
* Start a [BrowserSync](http://www.browsersync.io/) server, with watches on styles, js, images, and the style guide

### Pattern Lab

For information on Atomic Design and documentation for pattern lab, visit the [Pattern Lab website](http://patternlab.io/).

#### Viewing the style guide

After gulp is run for the first time, a style guide will be generated at [http://mast.dev/style-guide/index.html](http://mast.dev/style-guide/index.html).

#### Updating the style guide

Source files are located at:

    /public/skin/frontend/session/default/pattern-lab

Note: If the theme name is changed, also update `sourceDir` indicated in:

    /tools/pattern-lab/core/config/config.ini.default

And the theme path and name in:

    /public/skin/frontend/session/default/pattern-lab/_data/_data.json

#### About this build

MAST uses a fork of Pattern Lab which allows for configurable source and public directories. The PR from this fork to the official repo can be found here:

* [Pull request #288](https://github.com/pattern-lab/patternlab-php/pull/288)

This PR should be monitored and the official build should be used when the feature is merged.

### Theme fallback

For 1.13 the `session/default` theme will fall back to `base/default`. To change this, we have used the *Aoe_DesignFallback* module. Read more about it on [Fabrizio Branca's blog](http://fbrnc.net/blog/2012/03/custom-design-fallbacks-in-magento).

In 1.14 this is already set up for you using [this method](http://alanstorm.com/magento_parent_child_themes) and can be modified in the following file:

    app/design/frontend/session/default/etc/theme.xml

### Database / setup scripts

A default database or setup scripts with common settings will be added to this repo in the future.
