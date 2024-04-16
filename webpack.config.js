import path from 'path';

export default {
    mode: 'development',
    entry: './resources/js/app.js',
    output: {
        filename: 'bundle.js',
        path: path.resolve(new URL('.', import.meta.url).pathname, 'public'),
    }
};
