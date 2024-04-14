import {appendCategoryButton,categoryAppend,generateCartButtons} from "./scripts/dashboard.js";
window.appendCategoryButton=appendCategoryButton
window.categoryAppend=categoryAppend
window.generateCartButtons=generateCartButtons

import {adminkaEventManager} from "./scripts/adminka.js"
window.adminkaEventManager = adminkaEventManager

import {ProductEventManager} from "./scripts/cart.js"
window.ProductEventManager = ProductEventManager

import {OrderEventManager} from "./scripts/checkout.js"
window.OrderEventManager = OrderEventManager

import {adminHeaderButtonEventManager,headerButtonEventManager} from "./scripts/header.js"
window.adminHeaderButtonEventManager = adminHeaderButtonEventManager
window.headerButtonEventManager = headerButtonEventManager

import {productEventManager,replaceUnderScore} from "./scripts/product.js"
window.productEventManager = productEventManager
window.replaceUnderScore = replaceUnderScore

import {productEditEventManager} from "./scripts/productEdit.js"
window.productEditEventManager = productEditEventManager
