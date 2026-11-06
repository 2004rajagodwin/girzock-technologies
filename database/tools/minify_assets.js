// Builds the .min versions of the site's own CSS and JavaScript. The originals stay as the
// editable sources, so run this again after editing them:
//   npm install --no-save terser@5 clean-css@5
//   node database/tools/minify_assets.js
const fs = require('fs');
const path = require('path');
const { minify } = require('terser');
const CleanCSS = require('clean-css');

const root = path.resolve(__dirname, '..', '..', 'assets');
const css = ['css/style.css', 'css/girzock.css', 'css/girzock-dynamic.css'];
const js = ['js/main.js', 'js/girzock.js'];

(async () => {
	for (const file of css) {
		const source = fs.readFileSync(path.join(root, file), 'utf8');
		// Level 1 only: removes whitespace and comments, and does not restructure rules.
		const out = new CleanCSS({ level: 1, rebase: false }).minify(source);
		if (out.errors.length) throw new Error(file + ': ' + out.errors.join('; '));
		fs.writeFileSync(path.join(root, file.replace(/\.css$/, '.min.css')), out.styles);
		console.log(file, source.length, '->', out.styles.length);
	}
	for (const file of js) {
		const source = fs.readFileSync(path.join(root, file), 'utf8');
		const out = await minify(source, { compress: { passes: 1 }, mangle: true });
		fs.writeFileSync(path.join(root, file.replace(/\.js$/, '.min.js')), out.code);
		console.log(file, source.length, '->', out.code.length);
	}
})().catch((e) => { console.error(e); process.exit(1); });
