# Village One: Craft CMS Starter

An opinionated Craft CMS template to make starting our website projects at [Village One](https://www.village.one) easier. Uses Tailwind for styles, web components for JS and Vite for bundling, combined with a selection of plugins for SEO, redirects and caching.

## Batteries included

Here’s what this template configures beyond the standard Craft installer:

- set system timezone to Berlin
- set a bunch of sensible config defaults
  - prevent upscaling images
  - prevent gif/svg transforms
  - use emails as usernames
  - limit entry revisions
  - increase max upload size
  - disable template caching
- pre-install plugins
  - knock-knock to prevent access to staging site
  - Blitz for caching
  - SEOMatic for SEO fields
  - Retour for redirects
  - retcon for transforming html
  - CKEditor as a richtext field
  - vite for connecting the frontend
- frontend bundling happens via Vite, enabling HMR for css/js and full reloads for template changes
  - tailwind included with a basic theme config
  - some sensible css defaults
  - inter webfonts included, to be easily replaced
  - light/dark mode setup with a web component to switch between
  - print styles are preconfigured to smallest breakpoint and always light mode
- includes a local asset source and a few image transforms
- comprehensive readme for the instantiated project (see below)
- a simple blog
  - overview page with pagination
  - article page with next reads
  - RSS feed with full article content
- responsive image setup via srcset/sizes
- fully working deployment configs for Github Actions, assuming fortrabbit is used for hosting

## Issues

1. Doesn’t include any multilanguage setup yet, as not every site needs it.
2. HMR is currently broken with web components (sigh)
3. Plugin license keys are part of the project config
4. The deployment scripts currently don’t remove deleted files, which occasionally causes problems with Craft’s project config, e.g. when fields/sections get deleted. We need to improve this!

## First steps

This section is only relevant immediately after instantiating the template repo. We assume you have a copy of the template repo and you want to start turning it into a new project now. Follow these steps:

1. After cloning the new project repo, switch to a new branch (e.g. `chore/bootstrap`)
2. Open `.ddev/config.yml`. Give the project a new name where it says “village-craft” right at the top.
3. The Craft CMS license file is ignored in the template repo. In your copy, open the .gitignore file and delete the `config/license.key` line
4. Run `ddev config` and accept everything (no changes should be necessary)
5. Run `ddev composer install`
6. Run `ddev start`
7. Run `ddev craft install` in a second terminal and create an admin user, along with naming the site and specifying the local URL (e.g. https://project-name.ddev.site)
8. Configure .env file based on .env.example.dev
9. Go into Settings -> General and rename the system name
10. Go into Settings -> Sites and rename the primary site
11. Go into Settings -> Plugins and delete all plugin license keys, which will regenerate them
12. Check github actions deploy scripts, add secrets or delete what you don’t need
13. The current github actions scripts require the repository secrets `HOST`, `APP_NAME_STAGING`, `APP_NAME_PRODUCTION` and `SSH_PRIVATE_KEY`. [Here’s a post about generating the private key.](https://blog.fortrabbit.com/how-to-use-github-actions). The `HOST` is usually `deploy.eu2.frbit.com` and the app names follow a `xyz-stage` and `xyz-prod` naming.
14. Copy the local Craft security key from the .env file into the fortrabbit apps before you deploy
15. Delete everything above this line and adjust the project readme template below (search for TODO:)

---

# [TODO: PROJECT NAME]

This site is based on [Craft CMS](https://craftcms.com) and [ddev](https://ddev.readthedocs.io) for local development. It uses Vite for frontend bundling.

## Important links

- Staging site: [TODO: INSERT STAGING URL]
- Staging site CMS: [TODO: INSERT STAGING ADMIN URL]
- Live site: [TODO: INSERT PRODUCTION URL]
- Live site CMS: [TODO: INSERT PRODUCTION ADMIN URL]

The staging site password can be retrieved from `KNOCK_KNOCK_PASSWORD` in Fortrabbit ENV vars: https://dashboard.fortrabbit.com/apps/[TODO: APP NAME]/vars

## Local setup: first run

1. Install [Docker Desktop](https://www.docker.com/products/docker-desktop/) and [ddev](https://ddev.readthedocs.io/en/stable/). Start the Docker Desktop app.
2. Clone this repo and `cd` into the directory.
3. If this is your first time starting this site you might need `ddev config` before ([here’s a helpful article](https://blog.fortrabbit.com/local-craft-dev-site-ddev-development-tool) in case you run into problems), then run `ddev composer install` and then `ddev start`.
4. Once all containers are up ddev will print the local URL of the site, usually [TODO: INSERT LOCAL URL]. If it doesn’t, run `ddev describe`.
5. `ddev describe` is also helpful to access e.g. the database information, in case you want to dial into the db with a tool like [Sequel Ace](https://sequel-ace.com).

Here are the essential commands again, for easier skimming:

```
cd your/project/directory
ddev composer install
ddev start
```

If ddev didn’t prefill your `.env` file, duplicate the `.env.example.dev` to get started. Then enter db credentials from `ddev describe` (using the InDocker information).

The base system is running now, but you don’t have any data in the database and unfortunately Craft has no easy way to seed the database. Acquire a db dump and assets from another developer or start clean under [TODO: INSERT LOCAL BASE URL]/admin/install to create an admin account for the CMS. Then log in under [TODO: INSERT LOCAL BASE URL]/admin.

## Local setup: subsequent runs

Start Docker Desktop and `cd` into the repo’s directory, pull changes.

Now run:

```
ddev start
```

If you’ve pulled new code containing data structure changes or new system/plugin migrations, you’ll have to apply those:

```
ddev composer install
ddev craft up
```

The second line is a shortcut for these two individual commands, which you could also use separately:

```
ddev craft migrate/all
ddev craft project-config/apply
```

When you’re done: `ddev stop`

## Frontend bundling

We’re using [Vite](https://vitejs.dev) for bundling, along with the [Vite Craft CMS plugin](https://plugins.craftcms.com/vite) to enable cache busting. All CSS, JS and Twig templates are live reloaded upon save. [Here’s the guide we followed to set this up.](https://nystudio107.com/docs/vite/)

We’re using a ddev post-start hook to run all frontend bundling commands immediately after the containers have been spun up. So after executing `ddev start` all setup should be done for you automatically and the frontend dev server should start. If there’s an error, here’s a run-down of the commands, so you can manually go through them.

To get started install the correct node version and switch to it, then install dependencies:

```
ddev nvm install 20
ddev nvm use 20
ddev npm i
```

Now we can start the dev server (recommended for any local development):

```
ddev npm run dev
```

When visiting [TODO: INSERT LOCAL URL] in your browser, the dev tools console should confirm that an HMR (hot module reloading) connection has been established. This means changes to CSS/JS files will be applied live and the browser tab will reload upon Twig template changes.

You can also build optimized assets once for a production deployment:

```
ddev npm run build
```

Please note that Craft serves the assets differently based on its environmental configuration, so if you have dev mode enabled locally, you’ll have to use the assets dev server, while with dev mode disabled only the production build works. This has to do with how the assets are included to either enable hot module reloading (dev) or utilize cache busting (production).

## Branching strategy

We use feature branches and pull requests for development, never pushing to the `main` branch directly. If you’re starting development, do the following:

1. Pull the `main` branch
2. Create a new local branch from `main` (see below for naming the branch)
3. Do your feature development
4. Push your feature branch to GitHub
5. Create a pull request with your changes and describe what you did
6. Wait for somebody to review and accept or request changes

In terms of naming, we group feature branches into three main buckets: fixes, chores and features. Therefore, please name your branch following this convention:

```
fix/your-bug-fix-title
chore/your-maintenance-chore-title
feat/your-new-feature-title
```

## Deployments

We have two apps on Fortrabbit, `[TODO: STAGING APP NAME]` and `[TODO: PRODUCTION APP NAME]`, for staging and live environments, respectively. There are corresponding branches called `staging` and `production`. A Github Action will deploy any pushes to these branches to the matching apps.

### Staging and production deployments

If you want to deploy to staging or production, do the following:

- merge any outstanding pull requests into the `main` branch and pull it locally
- track and switch to the `staging`/`production` branch and merge the `main` branch into it (no merge commits please)
- push the `staging`/`production` branch to GitHub/origin

Now a [GitHub Action](https://github.com/village-one/[TODO: NEW PROJECT REPO NAME]/actions) will take over and perform the following actions:

- push the latest state to the fortrabbit app’s `main` branch
- run `composer install` on fortrabbit
- run `craft up` on fortrabbit, applying migrations and applying the project config
- build all static assets with Vite and sync them to fortrabbit
- clear and regenerate the blitz fullpage cache (only in production env)

You can watch the progress on GitHub in the Actions tab. Your changes will then be visible on staging/production URLs.

A few resources that were used in setting this up:

- [Deploying to Fortrabbit with GitHub Actions](https://blog.fortrabbit.com/how-to-use-github-actions)
- [Information on the fortrabbit.yml file](https://help.fortrabbit.com/deployment-file-v2) + [how to run multiple commands](https://www.culturefoundry.com/cultivate/technology/running-multiple-commands-after-deployment-to-fortrabbit/)

## CMS and plugins

We use Craft CMS 4. In Craft you configure all data structures visually in the CMS, which then get written to [the project config files](https://craftcms.com/docs/4.x/project-config.html), which are committed to the repo. Whenever somebody commits structural changes to the repo and somebody else pulls them, the CMS will prompt you to review and apply them (essentially a database migration). This can be done with one button click in the interface, but usually it’s safer to do it on the console. You can use ddev to access the [Craft CLI](https://craftcms.com/docs/4.x/console-commands.html), like so:

For a list of commands:

```
ddev craft
```

Apply outstanding migrations and then apply the project config:

```
ddev craft up
```

We currently use the following plugins:

- [Blitz](https://plugins.craftcms.com/blitz) for caching on staging/production
- [CKEditor](https://plugins.craftcms.com/ckeditor) for richtext fields
- [Knock Knock](https://plugins.craftcms.com/knock-knock) to password-protect the staging environment
- [Retcon](https://plugins.craftcms.com/retcon) to mangle apply css classes to richtext field content
- [Retour](https://plugins.craftcms.com/retour) for URL redirects
- [SEOmatic](https://nystudio107.com/docs/seomatic/) for SEO
- [Vite for Craft CMS](https://plugins.craftcms.com/vite) as a bridge to the Vite frontend bundling setup
