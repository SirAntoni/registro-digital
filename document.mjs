import WebViewer from '@pdftron/pdfjs-express-viewer'

const element = document.getElementById('viewer');

WebViewer({
  path: '/public', // point to where the files you copied are served from
  initialDoc: 'https://pdftron.s3.amazonaws.com/downloads/pl/PDFTRON_about.pdf' // path to your document
}, element).then((instance) => {
  // Call APIs here
})