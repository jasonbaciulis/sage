// import external dependencies
import 'jquery';

// Import everything from autoload
import "./autoload/**/*"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';

// base package
import fontawesome from "@fortawesome/fontawesome";
// Facebook and Twitter icons
import faFacebook from "@fortawesome/fontawesome-free-brands/faFacebook";
import faTwitter from "@fortawesome/fontawesome-free-brands/faTwitter";

// add the imported icons to the library
fontawesome.library.add(faFacebook, faTwitter);

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
