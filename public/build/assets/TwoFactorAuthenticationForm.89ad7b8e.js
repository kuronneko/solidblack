import{d as p,Y as E,o as t,e as a,a as l,r as H,b as s,w as o,g as n,t as C,a2 as R,n as x,P as N,u as Y,I as Q,G as D,c as y,h,f as u,F as G,i as U,a3 as z,C as A}from"./app.abf1df1e.js";import{b as O,a as W}from"./DialogModal.425ebca9.js";import{_ as B}from"./InputError.85379217.js";import{_ as $}from"./PrimaryButton.6c5775aa.js";import{_ as S}from"./SecondaryButton.2fd04823.js";import{_ as I}from"./TextInput.e6439ce1.js";import{_ as j}from"./DangerButton.93e9bf57.js";import{_ as J}from"./InputLabel.bc6fa2f8.js";import"./SectionTitle.6db973e7.js";import"./_plugin-vue_export-helper.cdc0426e.js";const X={class:"mt-4"},w={__name:"ConfirmsPassword",props:{title:{type:String,default:"Confirm Password"},content:{type:String,default:"For your security, please confirm your password to continue."},button:{type:String,default:"Confirm"}},emits:["confirmed"],setup(g,{emit:b}){const i=p(!1),e=E({password:"",error:"",processing:!1}),c=p(null),v=()=>{axios.get(route("password.confirmation")).then(r=>{r.data.confirmed?b("confirmed"):(i.value=!0,setTimeout(()=>c.value.focus(),250))})},_=()=>{e.processing=!0,axios.post(route("password.confirm"),{password:e.password}).then(()=>{e.processing=!1,d(),N().then(()=>b("confirmed"))}).catch(r=>{e.processing=!1,e.error=r.response.data.errors.password[0],c.value.focus()})},d=()=>{i.value=!1,e.password="",e.error=""};return(r,m)=>(t(),a("span",null,[l("span",{onClick:v},[H(r.$slots,"default")]),s(O,{show:i.value,onClose:d},{title:o(()=>[n(C(g.title),1)]),content:o(()=>[n(C(g.content)+" ",1),l("div",X,[s(I,{ref_key:"passwordInput",ref:c,modelValue:e.password,"onUpdate:modelValue":m[0]||(m[0]=T=>e.password=T),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:R(_,["enter"])},null,8,["modelValue","onKeyup"]),s(B,{message:e.error,class:"mt-2"},null,8,["message"])])]),footer:o(()=>[s(S,{onClick:d},{default:o(()=>[n(" Cancel ")]),_:1}),s($,{class:x(["ml-3",{"opacity-25":e.processing}]),disabled:e.processing,onClick:_},{default:o(()=>[n(C(g.button),1)]),_:1},8,["class","disabled"])]),_:1},8,["show"])]))}},Z={key:0,class:"text-lg font-medium text-gray-900 dark:text-gray-200"},ee={key:1,class:"text-lg font-medium text-gray-900 dark:text-gray-200"},te={key:2,class:"text-lg font-medium text-gray-900 dark:text-gray-200"},oe=l("div",{class:"mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400"},[l("p",null," When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application. ")],-1),ae={key:3},se={key:0},ne={class:"mt-4 max-w-xl text-sm text-gray-600"},re={key:0,class:"font-semibold"},le={key:1},ie=["innerHTML"],ce={key:0,class:"mt-4 max-w-xl text-sm text-gray-600"},ue={class:"font-semibold"},de=["innerHTML"],me={key:1,class:"mt-4"},fe={key:1},pe=l("div",{class:"mt-4 max-w-xl text-sm text-gray-600"},[l("p",{class:"font-semibold"}," Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost. ")],-1),_e={class:"grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg"},he={class:"mt-5"},ve={key:0},ye={key:1},Pe={__name:"TwoFactorAuthenticationForm",props:{requiresConfirmation:Boolean},setup(g){const b=g,i=p(!1),e=p(!1),c=p(!1),v=p(null),_=p(null),d=p([]),r=Y({code:""}),m=Q(()=>{var f;return!i.value&&((f=z().props.value.user)==null?void 0:f.two_factor_enabled)});D(m,()=>{m.value||(r.reset(),r.clearErrors())});const T=()=>{i.value=!0,A.Inertia.post("/user/two-factor-authentication",{},{preserveScroll:!0,onSuccess:()=>Promise.all([L(),M(),F()]),onFinish:()=>{i.value=!1,e.value=b.requiresConfirmation}})},L=()=>axios.get("/user/two-factor-qr-code").then(f=>{v.value=f.data.svg}),M=()=>axios.get("/user/two-factor-secret-key").then(f=>{_.value=f.data.secretKey}),F=()=>axios.get("/user/two-factor-recovery-codes").then(f=>{d.value=f.data}),P=()=>{r.post("/user/confirmed-two-factor-authentication",{errorBag:"confirmTwoFactorAuthentication",preserveScroll:!0,preserveState:!0,onSuccess:()=>{e.value=!1,v.value=null,_.value=null}})},q=()=>{axios.post("/user/two-factor-recovery-codes").then(()=>F())},V=()=>{c.value=!0,A.Inertia.delete("/user/two-factor-authentication",{preserveScroll:!0,onSuccess:()=>{c.value=!1,e.value=!1}})};return(f,K)=>(t(),y(W,null,{title:o(()=>[n(" Two Factor Authentication ")]),description:o(()=>[n(" Add additional security to your account using two factor authentication. ")]),content:o(()=>[h(m)&&!e.value?(t(),a("h3",Z," You have enabled two factor authentication. ")):h(m)&&e.value?(t(),a("h3",ee," Finish enabling two factor authentication. ")):(t(),a("h3",te," You have not enabled two factor authentication. ")),oe,h(m)?(t(),a("div",ae,[v.value?(t(),a("div",se,[l("div",ne,[e.value?(t(),a("p",re," To finish enabling two factor authentication, scan the following QR code using your phone's authenticator application or enter the setup key and provide the generated OTP code. ")):(t(),a("p",le," Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application or enter the setup key. "))]),l("div",{class:"mt-4",innerHTML:v.value},null,8,ie),_.value?(t(),a("div",ce,[l("p",ue,[n(" Setup Key: "),l("span",{innerHTML:_.value},null,8,de)])])):u("",!0),e.value?(t(),a("div",me,[s(J,{for:"code",value:"Code"}),s(I,{id:"code",modelValue:h(r).code,"onUpdate:modelValue":K[0]||(K[0]=k=>h(r).code=k),type:"text",name:"code",class:"block mt-1 w-1/2",inputmode:"numeric",autofocus:"",autocomplete:"one-time-code",onKeyup:R(P,["enter"])},null,8,["modelValue","onKeyup"]),s(B,{message:h(r).errors.code,class:"mt-2"},null,8,["message"])])):u("",!0)])):u("",!0),d.value.length>0&&!e.value?(t(),a("div",fe,[pe,l("div",_e,[(t(!0),a(G,null,U(d.value,k=>(t(),a("div",{key:k},C(k),1))),128))])])):u("",!0)])):u("",!0),l("div",he,[h(m)?(t(),a("div",ye,[s(w,{onConfirmed:P},{default:o(()=>[e.value?(t(),y($,{key:0,type:"button",class:x(["mr-3",{"opacity-25":i.value}]),disabled:i.value},{default:o(()=>[n(" Confirm ")]),_:1},8,["class","disabled"])):u("",!0)]),_:1}),s(w,{onConfirmed:q},{default:o(()=>[d.value.length>0&&!e.value?(t(),y(S,{key:0,class:"mr-3"},{default:o(()=>[n(" Regenerate Recovery Codes ")]),_:1})):u("",!0)]),_:1}),s(w,{onConfirmed:F},{default:o(()=>[d.value.length===0&&!e.value?(t(),y(S,{key:0,class:"mr-3"},{default:o(()=>[n(" Show Recovery Codes ")]),_:1})):u("",!0)]),_:1}),s(w,{onConfirmed:V},{default:o(()=>[e.value?(t(),y(S,{key:0,class:x({"opacity-25":c.value}),disabled:c.value},{default:o(()=>[n(" Cancel ")]),_:1},8,["class","disabled"])):u("",!0)]),_:1}),s(w,{onConfirmed:V},{default:o(()=>[e.value?u("",!0):(t(),y(j,{key:0,class:x({"opacity-25":c.value}),disabled:c.value},{default:o(()=>[n(" Disable ")]),_:1},8,["class","disabled"]))]),_:1})])):(t(),a("div",ve,[s(w,{onConfirmed:T},{default:o(()=>[s($,{type:"button",class:x({"opacity-25":i.value}),disabled:i.value},{default:o(()=>[n(" Enable ")]),_:1},8,["class","disabled"])]),_:1})]))])]),_:1}))}};export{Pe as default};
