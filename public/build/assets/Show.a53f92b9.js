import{_}from"./AppLayout.694e8672.js";import{L as h,Q as c,o as p,c as u,w as n,a as t,b as f,t as i}from"./app.5047d52d.js";import"./ckeditor.2ebe0c6d.js";import{_ as x}from"./PrimaryButton.2051b641.js";import{_ as b}from"./TextInput.2df70a25.js";import{_ as g}from"./InputLabel.3f0b8125.js";import{h as w}from"./moment.9709ab41.js";import{R as l}from"./fancybox.e18a0bea.js";import{_ as v}from"./_plugin-vue_export-helper.cdc0426e.js";const k={props:{blog:Object},data(){return{moment:w}},mounted(){l.bind('[data-fancybox="images"]',{Toolbar:{display:["close"]}}),document.querySelectorAll("img").forEach(o=>{const e=o.src.replace("_thumb",""),s=document.createElement("a");s.setAttribute("href",e),s.setAttribute("data-fancybox","images"),o.parentNode.insertBefore(s,o),s.appendChild(o)}),document.querySelectorAll("oembed[url]").forEach(o=>{const e=document.createElement("a");e.setAttribute("href",o.getAttribute("url")),e.className="embedly-card",o.appendChild(e)})},components:{AppLayout:_,PrimaryButton:x,TextInput:b,InputLabel:g,Link:h,Fancybox:l},methods:{}},y={class:"flex"},L=t("div",null,[t("h2",{class:"font-semibold text-xl leading-tight"}," Blog preview ")],-1),A={class:"ml-auto"},B=t("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-6 h-6"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"})],-1),M={class:"py-7"},S={class:"max-w-4xl mx-auto sm:px-6 lg:px-8"},C={class:"bg-white dark:bg-neutral-900 dark:text-neutral-200 overflow-hidden shadow-xl sm:rounded-lg"},E={class:"p-4 sm:px-6 ck-content"},N=["innerHTML"],T={class:"text-xs italic text-right mt-10 text-neutral-600 hover:text-blue-800 dark:hover:text-red-600"};function Y(a,o,e,s,r,$){const d=c("Link"),m=c("AppLayout");return p(),u(m,{title:"Blog - Show"},{header:n(()=>[t("div",y,[L,t("div",A,[f(d,{href:a.route("blog.index")},{default:n(()=>[B]),_:1},8,["href"])])])]),default:n(()=>[t("div",M,[t("div",S,[t("div",C,[t("div",E,[t("h2",null,i(e.blog.name),1),t("div",{innerHTML:e.blog.content},null,8,N),t("p",T,"Published at "+i(r.moment(e.blog.published_at).format("MMMM Do YYYY, h:mm:ss a")),1)])])])])]),_:1})}const Q=v(k,[["render",Y]]);export{Q as default};