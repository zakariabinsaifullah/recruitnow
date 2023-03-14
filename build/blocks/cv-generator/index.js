!function(){"use strict";var e,t={112:function(){var e=window.wp.element,t=window.wp.blocks,n=JSON.parse('{"apiVersion":2,"name":"rcn/cv-generator","version":"0.1.0","title":"CV Generator","category":"rcn-blocks","description":"show open application form widget","supports":{"html":false,"anchor":true},"attributes":{"isCandidateEnrollment":{"type":"boolean","default":true}},"textdomain":"recruitnow","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}'),r=window.wp.i18n,l=window.wp.blockEditor,o=window.wp.components;const{Fragment:i}=wp.element;(0,t.registerBlockType)(n,{icon:{src:(0,e.createElement)("svg",{clipRule:"evenodd",fillRule:"evenodd",strokeLinejoin:"round",strokeMiterlimit:"2",viewBox:"0 0 24 24"},(0,e.createElement)("path",{d:"m2.179 10.201c.055-.298.393-.734.934-.59.377.102.612.476.543.86-.077.529-.141.853-.141 1.529 0 4.47 3.601 8.495 8.502 8.495 2.173 0 4.241-.84 5.792-2.284l-1.251-.341c-.399-.107-.636-.519-.53-.919.108-.4.52-.637.919-.53l3.225.864c.399.108.637.519.53.919l-.875 3.241c-.107.399-.519.636-.919.53-.399-.107-.638-.518-.53-.918l.477-1.77c-1.829 1.711-4.27 2.708-6.838 2.708-5.849 0-9.968-4.8-10.002-9.93-.003-.473.027-1.119.164-1.864zm19.672 3.6c-.054.298-.392.734-.933.59-.378-.102-.614-.476-.543-.86.068-.48.139-.848.139-1.53 0-4.479-3.609-8.495-8.5-8.495-2.173 0-4.241.841-5.794 2.285l1.251.341c.4.107.638.518.531.918-.108.4-.519.637-.919.53l-3.225-.864c-.4-.107-.637-.518-.53-.918l.875-3.241c.107-.4.518-.638.918-.531.4.108.638.518.531.919l-.478 1.769c1.83-1.711 4.272-2.708 6.839-2.708 5.865 0 10.002 4.83 10.002 9.995 0 .724-.081 1.356-.164 1.8z",fillRule:"nonzero"}))},edit:function(t){let{attributes:n,setAttributes:a}=t;const{isCandidateEnrollment:c}=n;return(0,e.createElement)(i,null,(0,e.createElement)(l.InspectorControls,null,(0,e.createElement)(o.Card,null,(0,e.createElement)(o.CardHeader,null,(0,e.createElement)("strong",null,(0,r.__)("Form Settings","recruitnow"))),(0,e.createElement)(o.CardBody,null,(0,e.createElement)(o.ToggleControl,{label:(0,r.__)("Automatically enroll candidate","recruitnow"),checked:c,onChange:()=>a({isCandidateEnrollment:!c})})))),(0,e.createElement)("div",(0,l.useBlockProps)(),(0,e.createElement)("p",{className:"note"},(0,e.createElement)("strong",null,(0,r.__)("Note: ","recruitnow")," "),(0,r.__)("Preview is not available for this block. Please use the frontend to preview.","recruitnow")),(0,e.createElement)("div",{className:"settings-area"},(0,e.createElement)(o.Card,null,(0,e.createElement)(o.CardHeader,null,(0,e.createElement)("strong",null,(0,r.__)("Form Settings","recruitnow"))),(0,e.createElement)(o.CardBody,null,(0,e.createElement)(o.ToggleControl,{label:(0,r.__)("Automatically enroll candidate","recruitnow"),checked:c,onChange:()=>a({isCandidateEnrollment:!c})}))))))},save:function(){return null}})}},n={};function r(e){var l=n[e];if(void 0!==l)return l.exports;var o=n[e]={exports:{}};return t[e](o,o.exports,r),o.exports}r.m=t,e=[],r.O=function(t,n,l,o){if(!n){var i=1/0;for(u=0;u<e.length;u++){n=e[u][0],l=e[u][1],o=e[u][2];for(var a=!0,c=0;c<n.length;c++)(!1&o||i>=o)&&Object.keys(r.O).every((function(e){return r.O[e](n[c])}))?n.splice(c--,1):(a=!1,o<i&&(i=o));if(a){e.splice(u--,1);var s=l();void 0!==s&&(t=s)}}return t}o=o||0;for(var u=e.length;u>0&&e[u-1][2]>o;u--)e[u]=e[u-1];e[u]=[n,l,o]},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={548:0,530:0};r.O.j=function(t){return 0===e[t]};var t=function(t,n){var l,o,i=n[0],a=n[1],c=n[2],s=0;if(i.some((function(t){return 0!==e[t]}))){for(l in a)r.o(a,l)&&(r.m[l]=a[l]);if(c)var u=c(r)}for(t&&t(n);s<i.length;s++)o=i[s],r.o(e,o)&&e[o]&&e[o][0](),e[o]=0;return r.O(u)},n=self.webpackChunkgutenberg_boilerplate=self.webpackChunkgutenberg_boilerplate||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))}();var l=r.O(void 0,[530],(function(){return r(112)}));l=r.O(l)}();