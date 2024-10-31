# Development environment

A local development environment is included in this repository using `wp-scripts`. Run the following commands to use it:

- `npm run start` - Start the environment
- `npm run stop` - Stop the environment
- `npm run wp` - WP Cli access to the environment

# Development

To lint your code, run the following command: `composer lint`. To clean your code and fix syntax/style errors, run `composer clean`.

To build or update the .pot language file, run `composer make-pot`.

# Deployment

This plugin should always be built and deployed by Github using the Github action included in the repository. This action removes unneeded files and only packages what is needed for the plugin to run.

To deploy a new version to SVN, simple add a tag with the version number. i.e. `v1.0.3` (without the preceding `v` on the tag, the deployment will not work).
