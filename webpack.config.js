const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = {
  mode: 'development',
  watch: true,
  entry: {
    'js/app' : './src/js/app.js',
    'js/inicio' : './src/js/inicio.js',
    'js/organizacion/index' : './src/js/organizacion/index.js',
    'js/tipo/index' : './src/js/tipo/index.js',
    'js/nacionalidad/index' : './src/js/nacionalidad/index.js',
    'js/colores/index' : './src/js/colores/index.js',
    'js/armas/index' : './src/js/armas/index.js',
    'js/calibres/index' : './src/js/calibres/index.js',
    'js/delitos/index' : './src/js/delitos/index.js',
    'js/desastre_natural/index' : './src/js/desastre_natural/index.js',
    'js/fenomeno_natural/index' : './src/js/fenomeno_natural/index.js',
    'js/moneda/index' : './src/js/moneda/index.js',
    'js/eventos/index' : './src/js/eventos/index.js',
    'js/mapas/infoCapturas' : './src/js/mapas/infoCapturas.js',
    'js/mapas/infoDroga' : './src/js/mapas/infoDroga.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build')
  },
  plugins: [
    new MiniCssExtractPlugin({
        filename: 'styles.css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
            {
                loader: MiniCssExtractPlugin.loader
            },
            'css-loader',
            'sass-loader'
        ]
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        loader: 'file-loader',
        options: {
           name: 'img/[name].[hash:7].[ext]'
        }
      },
    ]
  }
};