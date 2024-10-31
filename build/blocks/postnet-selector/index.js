(()=>{"use strict";var e,r={873:()=>{const e=window.wp.blocks,r=window.wp.blockEditor,o=window.wp.components,t=window.wp.i18n,l=window.ReactJSXRuntime,s=JSON.parse('{"apiVersion":2,"name":"scrubbill/postnet-selector-block","version":"1.0","title":"PostNet Branch Selector","category":"woocommerce","description":"Adds a drop down selector for a user to choose a PostNet branch.","supports":{"html":false,"align":false,"multiple":false,"reusable":false},"parent":["woocommerce/checkout-shipping-methods-block"],"attributes":{"lock":{"type":"object","default":{"remove":true,"move":true}}},"textdomain":"scrubbill","editorScript":"file:./index.js"}');(0,e.registerBlockType)(s,{edit:()=>{const e=(0,r.useBlockProps)();return(0,l.jsxs)("div",{...e,style:{display:"block"},children:[(0,l.jsx)("h2",{children:(0,t.__)("PostNet Branch","scrubbill")}),(0,l.jsx)(o.Disabled,{children:(0,l.jsx)(o.SelectControl,{options:[{label:(0,t.__)("Select a PostNet","scrubbill"),value:""}]})})]})}})}},o={};function t(e){var l=o[e];if(void 0!==l)return l.exports;var s=o[e]={exports:{}};return r[e](s,s.exports,t),s.exports}t.m=r,e=[],t.O=(r,o,l,s)=>{if(!o){var i=1/0;for(p=0;p<e.length;p++){o=e[p][0],l=e[p][1],s=e[p][2];for(var c=!0,n=0;n<o.length;n++)(!1&s||i>=s)&&Object.keys(t.O).every((e=>t.O[e](o[n])))?o.splice(n--,1):(c=!1,s<i&&(i=s));if(c){e.splice(p--,1);var a=l();void 0!==a&&(r=a)}}return r}s=s||0;for(var p=e.length;p>0&&e[p-1][2]>s;p--)e[p]=e[p-1];e[p]=[o,l,s]},t.o=(e,r)=>Object.prototype.hasOwnProperty.call(e,r),(()=>{var e={2:0,382:0};t.O.j=r=>0===e[r];var r=(r,o)=>{var l,s,i=o[0],c=o[1],n=o[2],a=0;if(i.some((r=>0!==e[r]))){for(l in c)t.o(c,l)&&(t.m[l]=c[l]);if(n)var p=n(t)}for(r&&r(o);a<i.length;a++)s=i[a],t.o(e,s)&&e[s]&&e[s][0](),e[s]=0;return t.O(p)},o=self.webpackChunk_scrubbill_scrubbill_wp_plugin=self.webpackChunk_scrubbill_scrubbill_wp_plugin||[];o.forEach(r.bind(null,0)),o.push=r.bind(null,o.push.bind(o))})();var l=t.O(void 0,[382],(()=>t(873)));l=t.O(l)})();