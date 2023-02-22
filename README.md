# Agora Folio UOC Theme

## Description

Agora Folio UOC theme for Agora blog types.

### Languages Available

- English
- Catalan
- Spanish (Supported by Author)

### Installation

1. Upload the 'agora-folio' folder to the '/wp-content/themes/' directory
2. Activate the theme through the 'Appearance > Themes' menu in WordPress

## Developing With npm, Webpack (Laravel Mix) and SASS

### Installing Dependencies

- Make sure you have installed Node.js and NPM, on your computer globally.
- Then open your terminal and browse to the location of your theme copy
- Run: `$ npm install`

### Running

To work with and compile your Sass files, and generate development assets on the fly run:

```
$ npm run watch
```

To compile asssets for development run:

```
$ npm run development
```

To compile assets for production run:

```
$ npm run production
```

### Changelog

#### v1.0.0
- Initial release

#### v1.0.1
- Tree comments view
- Minor fixes

#### v1.0.2
- Folio - Canvis Àgora 2.1 
- Tree comments view - Replace sticky-js by standard position sticky

#### v1.0.3
- FOLIO-54: Evaluation form disabled, redirect to RAC

#### v1.0.4
- FOLIO-57: Permitir seleccionar si queremos usar la evaluación desde folio o desde rac

#### v1.0.5
- FOLIO-55: Preparación de theme para permisos de comentarios
- Ordenación: implementación por Nombre, Apellidos y Título. Comentada de momento la aordenación por Evaluación y Actividad

#### v1.0.6
- Actualizado logo y favicons con el icono de Grupo GEF
- Incluido buscador tipo collapse en la cabecera de breadcrumbs/filters
- Modificado enlace folio estudiante en nueva ventana y cambio de icono

#### v1.0.7
- Fix comments open in lists (home, archive, categories)

#### v1.0.8
- Folio-lab-operatiu: Evaluación

#### v1.0.9
- Mosaic grid view refactoring
- Update translations
- Header cta mi folio
- Remove tree view menu counters
- Post and comment author classroom avatar

#### v1.0.10
- Added .npmrc config file for pnpm build
- Archive, grid, list, single and comments views refactoring
- Fix site.webmanifest
- Fix GEF: dart sass division migration
- Comment access visibility ajax fix
- Updated filters/order view
