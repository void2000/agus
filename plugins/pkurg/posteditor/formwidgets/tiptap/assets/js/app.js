(function(e){function t(t){for(var r,l,a=t[0],i=t[1],s=t[2],p=0,d=[];p<a.length;p++)l=a[p],Object.prototype.hasOwnProperty.call(o,l)&&o[l]&&d.push(o[l][0]),o[l]=0;for(r in i)Object.prototype.hasOwnProperty.call(i,r)&&(e[r]=i[r]);c&&c(t);while(d.length)d.shift()();return u.push.apply(u,s||[]),n()}function n(){for(var e,t=0;t<u.length;t++){for(var n=u[t],r=!0,a=1;a<n.length;a++){var i=n[a];0!==o[i]&&(r=!1)}r&&(u.splice(t--,1),e=l(l.s=n[0]))}return e}var r={},o={app:0},u=[];function l(t){if(r[t])return r[t].exports;var n=r[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,l),n.l=!0,n.exports}l.m=e,l.c=r,l.d=function(e,t,n){l.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},l.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},l.t=function(e,t){if(1&t&&(e=l(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(l.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)l.d(n,r,function(t){return e[t]}.bind(null,r));return n},l.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return l.d(t,"a",t),t},l.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},l.p="/";var a=window["webpackJsonp"]=window["webpackJsonp"]||[],i=a.push.bind(a);a.push=t,a=a.slice();for(var s=0;s<a.length;s++)t(a[s]);var c=i;u.push([0,"chunk-vendors"]),n()})({0:function(e,t,n){e.exports=n("56d7")},"56d7":function(e,t,n){"use strict";n.r(t);var r=n("2b0e"),o=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"elements-tiptap-editor",attrs:{id:e.query.value+"-editor"}},[n("Editor",{attrs:{wid:{query:e.query}}})],1)},u=[],l=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("el-tiptap",{style:{height:e.filterSectionHeight+"px"},attrs:{"menu-bubble-options":{"keep-in-bounds":!1},extensions:e.extensions,content:e.content,placeholder:"Write something ..."},on:{onInit:e.onInitEvent,onUpdate:e.onUpdateEvent}})},a=[],i=n("4ccc"),s=n("56b3"),c=n.n(s),p=(n("a7be"),n("d5e0"),n("31c5"),n("05dd"),n("bc3a")),d=n.n(p);async function w(e){let t=new FormData;t.append("file",e);const n={"Content-Type":"multipart/form-data"},r=await d.a.post("/elements-tiptap-upload",t,{headers:n});return r.data.src}var f={props:["wid"],name:"Editor",data:()=>({height:document.getElementById("Form-field-Post-content-group").offsetHeight-4,extensions:[new i["f"],new i["D"],new i["v"],new i["k"]({level:5}),new i["b"]({bubble:!0}),new i["K"]({bubble:!0}),new i["q"]({bubble:!0}),new i["y"]({bubble:!0}),new i["s"]({bubble:!0}),new i["o"]({urlPattern:/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})/,uploadRequest:w}),new i["a"],new i["E"],new i["t"],new i["c"]({bubble:!0}),new i["u"]({bubble:!0}),new i["H"],new i["I"],new i["p"],new i["r"],new i["n"],new i["d"],new i["J"],new i["z"],new i["B"],new i["A"],new i["C"],new i["h"],new i["F"],new i["G"],new i["w"],new i["x"],new i["j"],new i["m"]({bubble:!0}),new i["i"],new i["e"]({codemirror:c.a,codemirrorOptions:{styleActiveLine:!0,autoCloseTags:!0}}),new i["l"]],content:""}),computed:{filterSectionHeight(){return this.height}},methods:{onInitEvent(){this.content=document.getElementById(this.wid.query.value).value},onUpdateEvent(e,t){const{getHTML:n}=t;document.getElementById(this.wid.query.value).value=n()}},mounted:function(){var e=this;setInterval((function(){e.height=document.getElementById("Form-field-Post-content-group").offsetHeight-4}),10)}},b=f,h=n("2877"),m=Object(h["a"])(b,l,a,!1,null,null,null),v=m.exports,y={props:["query"],name:"App",components:{Editor:v},mounted:function(){}},g=y,E=Object(h["a"])(g,o,u,!1,null,null,null),x=E.exports,O=n("5c96"),j=n.n(O);n("7eef");r["default"].use(j.a),r["default"].use(i["g"],{lang:document.getElementById("curlocale").attributes.lang.value}),r["default"].config.productionTip=!1;for(var A=r["default"].extend({render(e){return e(x,{props:{query:this.$el.attributes.wid}})}}),q=document.querySelectorAll(".elements-tiptap-root"),I=0;I<q.length;++I)new A({el:q[I]})}});
//# sourceMappingURL=app.dcdeeebf.js.map