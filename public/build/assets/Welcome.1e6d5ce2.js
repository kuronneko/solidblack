import{_ as f}from"./AppLayout.03855679.js";import{L as b,H as k,Q as m,o,e as a,b as h,a as t,c as x,w as p,f as r,t as c,F as u,i as w,g as v}from"./app.684021d7.js";import"./ckeditor.bf92b68e.js";import{_ as y}from"./PrimaryButton.8bf08c7c.js";import{_ as C}from"./TextInput.8b80f5e7.js";import{_ as L}from"./InputLabel.edd37dd1.js";import{h as M}from"./moment.9709ab41.js";import{R as S}from"./fancybox.e18a0bea.js";import{_ as B}from"./_plugin-vue_export-helper.cdc0426e.js";const H={props:{canLogin:Boolean,canRegister:Boolean,laravelVersion:String,phpVersion:String,setting:Object},data(){return{images:["/img/banner (1).png","/img/banner (2).png","/img/banner (3).png","/img/banner (4).png","/img/banner (5).png","/img/banner (6).png","/img/banner (7).png","/img/banner (8).png","/img/banner (9).png","/img/banner (10).png","/img/banner (11).png","/img/banner (12).png","/img/banner (13).png","/img/banner (14).png","/img/banner (15).png","/img/banner (16).png","/img/banner (17).png","/img/banner (18).png","/img/banner (19).png"],blogs:[],moment:M,start:6,take:6,stop:!1,isLoading:!1,style:localStorage.theme}},beforeMount(){this.getInitialBlogs()},mounted(){localStorage.theme==="dark"||!("theme"in localStorage)&&window.matchMedia("(prefers-color-scheme: dark)").matches?(document.documentElement.classList.add("dark"),localStorage.theme="dark",this.style=localStorage.theme):(document.documentElement.classList.remove("dark"),localStorage.theme="light",this.style=localStorage.theme),this.getNextBlog(),document.querySelectorAll("oembed[url]").forEach(e=>{const n=document.createElement("a");n.setAttribute("href",e.getAttribute("url")),n.className="embedly-card",e.appendChild(n)})},components:{AppLayout:f,PrimaryButton:y,TextInput:C,InputLabel:L,Link:b,Fancybox:S,Head:k},computed:{randomImage(){const e=Math.floor(Math.random()*this.images.length);return this.images[e]}},methods:{toggle(){localStorage.theme==="dark"?(localStorage.theme="light",this.style=localStorage.theme,document.documentElement.classList.remove("dark")):(localStorage.theme="dark",this.style=localStorage.theme,document.documentElement.classList.add("dark"))},getInitialBlogs(){this.axios.get(`blog/all?skip=${0}&take=${this.take}`).then(e=>{this.blogs=e.data.blogs})},getNextBlog(){window.onscroll=()=>{const e=document.getElementById("blogs-container");window.innerHeight+window.pageYOffset>=e.offsetTop+e.offsetHeight&&!this.stop&&!this.isLoading&&(this.isLoading=!0,setTimeout(()=>{axios.get(`blog/all?skip=${this.start}&take=${this.take}`).then(i=>{this.blogs.push(...i.data.blogs),this.start=this.start+this.take,i.data.blogs.length===0&&(this.stop=!0),this.isLoading=!1})},Math.floor(Math.random()*(800-300+1)+300)))}}}},E={class:"relative max-w-4xl mx-auto py-2"},I={key:0,class:"absolute top-0 right-0 px-6 py-4 sm:block"},N={class:"absolute top-0 left-0 px-6 py-4 sm:block text-gray-700 dark:text-gray-500 inset-0"},V={key:0},j=t("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-6 h-6"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"})],-1),A=[j],T={key:1},Y=t("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor",class:"w-6 h-6"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"})],-1),F=[Y],O={class:"flex items-center justify-center"},$={class:"mt-10 rounded-lg dark:text-white",id:"logo-container"},D={class:"flex items-center justify-center"},Z={class:"px-5 py-5",id:"logo-container"},z=["src"],P={class:"pt-3 mb-6",id:"blogs-container"},R={class:"max-w-4xl mx-auto sm:px-6 lg:px-8 pb-2"},q={class:"bg-white dark:bg-neutral-900 dark:text-neutral-200 overflow-hidden shadow-xl sm:rounded-lg"},Q={class:"p-4 sm:px-6 ck-content"},W={class:"hover:text-blue-800 dark:hover:text-red-600"},G=["innerHTML"],J={class:"text-xs italic text-right mt-10 text-neutral-600 hover:text-blue-800 dark:hover:text-red-600"},K={key:0,role:"status",class:"flex justify-center ... mb-10"},U=t("div",{role:"status"},[t("svg",{"aria-hidden":"true",class:"inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300",viewBox:"0 0 100 101",fill:"none",xmlns:"http://www.w3.org/2000/svg"},[t("path",{d:"M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z",fill:"currentColor"}),t("path",{d:"M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z",fill:"currentFill"})]),t("span",{class:"sr-only"},"Loading...")],-1),X=t("span",{class:"sr-only"},"Loading...",-1),tt=[U,X];function et(e,n,i,st,l,d){const _=m("Head"),g=m("Link");return o(),a(u,null,[h(_,{title:"Home"}),t("div",E,[i.canLogin?(o(),a("div",I,[e.$page.props.user?(o(),x(g,{key:0,href:e.route("dashboard"),class:"text-md text-gray-700 dark:text-gray-500"},{default:p(()=>[v(" Dashboard ")]),_:1},8,["href"])):r("",!0)])):r("",!0),t("div",N,[t("button",{id:"toggle-dark-mode",onClick:n[0]||(n[0]=(...s)=>d.toggle&&d.toggle(...s))},[this.style=="dark"?(o(),a("div",V,A)):r("",!0),this.style=="light"?(o(),a("div",T,F)):r("",!0)])])]),t("div",O,[t("div",$,c(i.setting.status),1)]),t("div",D,[t("div",Z,[t("img",{src:d.randomImage,alt:"",class:"w-32 h-auto"},null,8,z)])]),t("div",P,[(o(!0),a(u,null,w(l.blogs,s=>(o(),a("div",{key:s.id},[t("div",R,[t("div",q,[t("div",Q,[h(g,{href:e.route("blog.show.with.slug",[s.slug])},{default:p(()=>[t("h3",W,c(s.name),1)]),_:2},1032,["href"]),t("div",{innerHTML:s.content.slice(0,300)+(s.content.length>300?"...":"")},null,8,G),t("p",J," Published at "+c(l.moment(s.published_at).format("MMMM Do YYYY, h:mm:ss a")),1)])])])]))),128))]),!l.stop&&l.isLoading?(o(),a("div",K,tt)):r("",!0)],64)}const mt=B(H,[["render",et]]);export{mt as default};
