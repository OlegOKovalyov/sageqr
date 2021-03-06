// import external dependencies
import 'jquery';

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import login from './routes/login';
import home from './routes/home';
import aboutUs from './routes/about';
import myProfile from './routes/myprofile';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  login,
  // Login page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  // My Profile page, note the change from my-profile to myProfile.
  myProfile,  
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());


// import then needed Font Awesome functionality
import { library, dom } from '@fortawesome/fontawesome-svg-core';
// import the Facebook and Twitter icons
import { faFont, faEnvelope, faLock, faCheck, faUser, faPowerOff, faKey, faAngleDown,
	faPlus, faHome, faDownload, faFileImage, faCloudUploadAlt, faFolderPlus, faFolder,
	faUserPlus, faArrowsAlt, faSplotch } from '@fortawesome/free-solid-svg-icons';
import { faArrowAltCircleLeft, faArrowAltCircleRight, faStar, faEdit, faTrashAlt, faEye,
	faClock } from '@fortawesome/free-regular-svg-icons';
import { faFacebook, faTwitter } from '@fortawesome/free-brands-svg-icons';

// add the imported icons to the library
library.add(faFacebook, faTwitter, faFont, faEnvelope, faLock, faCheck, faArrowAltCircleLeft, 
	faArrowAltCircleRight, faUser, faPowerOff, faKey, faAngleDown, faPlus, faHome, faDownload, 
	faFileImage, faCloudUploadAlt, faFolderPlus, faFolder, faStar, faUserPlus, faEdit, faTrashAlt,
	faEye, faClock, faArrowsAlt, faSplotch );

// tell FontAwesome to watch the DOM and add the SVGs when it detects icon markup
dom.watch();