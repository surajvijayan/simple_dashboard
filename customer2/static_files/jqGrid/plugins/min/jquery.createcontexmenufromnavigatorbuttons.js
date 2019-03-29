/**
 * @license Copyright (c) 2014-2018, Dr. Oleg Kiriljuk, oleg.kiriljuk@ok-soft-gmbh.com
 * Dual licensed under the MIT and GPL licenses
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl-2.0.html
 * Date: 2015-04-06
 * see the answers http://stackoverflow.com/a/8491939/315935
 *             and http://stackoverflow.com/a/29048089/315935
 *             and http://stackoverflow.com/q/29457007/315935
 */
!function(t,n){"use strict";"function"==typeof define&&define.amd?define(["jquery","./jquery.contextmenu-ui","free-jqgrid/grid.base"],function(e){return n(e,t,t.document)}):"object"==typeof module&&module.exports?module.exports=function(e,t){return void 0===t&&(t="undefined"!=typeof window?require("jquery"):require("jquery")(e||window)),require("./jquery.contextmenu-ui"),require("free-jqgrid/grid.base"),n(t,e,e.document),t}:n(jQuery,t,t.document)}("undefined"!=typeof window?window:this,function(c,a,l){"use strict";c.jgrid.extend({createContexMenuFromNavigatorButtons:function(i,r){var d=this,e="menu_"+d[0].id,t=c("<ul>"),n=c("<div>").attr("id",e);t.appendTo(n),n.appendTo("body"),d.contextMenu(e,{bindings:{},onContextMenu:function(e){var t,n,i,r=d[0].p,o=c(e.target),u=o.closest("tr.jqgrow").attr("id"),s=o.is(":text:enabled")||o.is("input[type=textarea]:enabled")||o.is("textarea:enabled");return!(!u||s||""!==(i="",a.getSelection?i=a.getSelection():l.getSelection?i=l.getSelection():l.selection&&(i=l.selection.createRange().text),"string"==typeof i?i:i.toString()))&&(t=c.inArray(u,r.selarrrow),r.selrow!==u&&t<0?d.jqGrid("setSelection",u):r.multiselect&&(n=r.selarrrow[r.selarrrow.length-1],t!==r.selarrrow.length-1&&(r.selarrrow[r.selarrrow.length-1]=u,r.selarrrow[t]=n,r.selrow=u)),!0)},onShowMenu:function(e,t){var s=this,a=t.children("ul").first().empty(),n=null!=c.ui&&"string"==typeof c.ui.version?/^([0-9]+)\.([0-9]+)\.([0-9]+)$/.exec(c.ui.version):[],l=null!=n&&4===n.length&&"1"===n[1]&&n[2]<11;return c(i).find(".navtable .ui-pg-button").filter(function(){return!(c(this).prop("disabled")||c(this).hasClass("ui-state-disabled"))}).each(function(){var e,t,n,i,r,o,u=c(this).children("div.ui-pg-div").first();1===u.length&&(t=u.children(".ui-pg-button-text").html(),n=u.parent(),""===c.trim(t)&&(t=n.attr("title")),i=""!==this.id&&""!==t?"menuitem_"+this.id:c.jgrid.randId(),r=c("<li>").attr("id",i),0<(e=u.children("span").not(".ui-pg-button-text").first()).length&&(l?r.append(c("<a>").html(t).prepend(e.clone().removeClass("ui-pg-button-icon-over-text").css({float:"left",marginTop:e.hasClass("ui-icon")?"0.25em":"0.125em",marginRight:"0.5em"}))):r.html(t).prepend(e.clone().removeClass("ui-pg-button-icon-over-text").css({float:"left",marginTop:e.first().hasClass("ui-icon")?"0.25em":"0.125em",marginRight:"0.5em"})),u.parent().hasClass("ui-state-active")&&r.find("span").addClass("ui-state-active"),0<r.find("select,input").length&&r.hide(),a.append(r),s.bindings[i]=(o=u,function(){o.click()})))}),c.jgrid.fullBoolFeedback.call(d,(r||{}).onShowContextMenu,"jqGridShowContextMenu",a,s),t}})}})});
//# sourceMappingURL=jquery.createcontexmenufromnavigatorbuttons.js.map