# Super Awesome Theme (Boilerplate)

This is my personal theme boilerplate, initially based on \_s, partly inspired by Twenty Seventeen, with lots of additional features.

## Getting Started

To create your own theme, download this repository. For the next steps, let's assume your theme should be called `Taco World`.

1. Rename the directory to `taco-world`.
2. Open `gulpfile.js` and scroll to the bottom.
3. Replace every value in the `replacements` object with your new theme name or theme author data in the appropriate format. For example, replace `my-new-theme-name` with `taco-world`, `MY_NEW_THEME_NAME` with `TACO_WORLD` and so on. Replace the author name, email and website with your respective data.
4. Save the changes.
5. Run `npm install` in the console.
6. Run `gulp init-replace` in the console.
7. Open `gulpfile.js` again and remove the entire bottom section that starts with `INITIAL SETUP TASK`, save the file afterwards.
8. Check the `package.json` file. You might wanna update some details to your preferences.
9. Check the top of `gulpfile.js`, containing the `tags` and `config` objects. You might wanna update some details to your preferences.
10. Run `gulp build` once to compile everything.

Now you're good to go! One more thing: If you want to publish the theme on wordpress.org, it's recommended to remove the `/languages` directory, plus set the `config.domainPath` to `false` and remove the `pot` task in `gulpfile.js`.

## Common Gulp Tasks

* `gulp sass`: Lints and compiles CSS/Sass
* `gulp js`: Lints and compiles JavaScript
* `gulp img`: Compresses images
* `gulp pot`: Refreshes POT file
* `gulp readme`: Replaces the header and description in the readme with latest data
* `gulp build`: Runs all of the above tasks

TODO: codeclimate.yml, PHPCS, PHPMD
