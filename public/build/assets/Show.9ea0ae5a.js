import{_ as h}from"./AppLayout.c4e01043.js";import{L as p,Q as l,o as u,c as f,w as a,a as t,b as i,t as d}from"./app.1a19699e.js";import"./ckeditor.690e129a.js";import{_ as x}from"./PrimaryButton.5452ee96.js";import{_ as b}from"./TextInput.014f8b26.js";import{_ as g}from"./InputLabel.f099a4f5.js";import{h as v}from"./moment.9709ab41.js";import{R as m}from"./fancybox.e18a0bea.js";import{_ as w}from"./_plugin-vue_export-helper.cdc0426e.js";const k={props:{blog:Object},data(){return{moment:v}},mounted(){m.bind('[data-fancybox="images"]',{Toolbar:{display:["close"]}}),document.querySelectorAll("img").forEach(o=>{const e=o.src.replace("_thumb",""),s=document.createElement("a");s.setAttribute("href",e),s.setAttribute("data-fancybox","images"),o.parentNode.insertBefore(s,o),s.appendChild(o)}),document.querySelectorAll("oembed[url]").forEach(o=>{const e=document.createElement("a");e.setAttribute("href",o.getAttribute("url")),e.className="embedly-card",o.appendChild(e)})},components:{AppLayout:h,PrimaryButton:x,TextInput:b,InputLabel:g,Link:p,Fancybox:m},methods:{}},y={class:"flex"},L=t("div",null,[t("h2",{class:"font-semibold text-xl leading-tight"}," Blog preview ")],-1),A={class:"ml-auto"},B=t("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-6 h-6"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"})],-1),M={class:"py-7"},S={class:"max-w-4xl mx-auto sm:px-6 lg:px-8"},C={class:"bg-white dark:bg-neutral-900 dark:text-neutral-200 overflow-hidden shadow-xl sm:rounded-lg"},E={class:"p-4 sm:px-6 ck-content"},N={class:"hover:text-blue-800 dark:hover:text-red-600"},T=["innerHTML"],Y={class:"text-xs italic text-right mt-5 text-neutral-600 hover:text-blue-800 dark:hover:text-red-600"};function $(n,o,e,s,r,j){const c=l("Link"),_=l("AppLayout");return u(),f(_,{title:"Blog - Show"},{header:a(()=>[t("div",y,[L,t("div",A,[i(c,{href:n.route("blog.index")},{default:a(()=>[B]),_:1},8,["href"])])])]),default:a(()=>[t("div",M,[t("div",S,[t("div",C,[t("div",E,[i(c,null,{default:a(()=>[t("h3",N,d(e.blog.name),1)]),_:1}),t("div",{innerHTML:e.blog.content},null,8,T),t("p",Y,"Published at "+d(r.moment(e.blog.published_at).format("MMMM Do YYYY, h:mm:ss a")),1)])])])])]),_:1})}const R=w(k,[["render",$]]);export{R as default};