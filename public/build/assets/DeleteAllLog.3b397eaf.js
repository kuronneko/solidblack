import{d as p,a0 as h,u as v,o as L,c as x,w as e,g as o,a as c,b as t,h as a,a2 as k,n as C}from"./app.27c55212.js";import{_ as D}from"./ActionSection.bef64749.js";import{_ as f}from"./DangerButton.b4c6c9e5.js";import{a as $}from"./DialogModal.81e786c2.js";import{_ as b}from"./InputError.883179e7.js";import{_ as B}from"./SecondaryButton.0608a081.js";import{_ as V}from"./TextInput.21224945.js";import"./SectionTitle.1b129af8.js";import"./_plugin-vue_export-helper.cdc0426e.js";const T=c("div",{class:"max-w-xl text-sm text-gray-600"}," Once your logs is deleted, all of its resources and data will be permanently deleted. Before deleting your logs, please download any data or information that you wish to retain. ",-1),P={class:"mt-5"},A={class:"mt-4"},U={__name:"DeleteAllLog",setup(E){const l=p(!1),r=p(null),n=h("$swal"),s=v({password:""}),_=()=>{l.value=!0,setTimeout(()=>r.value.focus(),250)},u=()=>{s.delete(route("delete_all_logs"),{preserveScroll:!0,onSuccess:()=>g(),onError:()=>r.value.focus(),onFinish:()=>s.reset()})},i=()=>{l.value=!1,s.reset()},g=()=>{w().fire({icon:"success",title:"All Logs was deleted successfully"}),i()},w=()=>n.mixin({toast:!0,position:"top",showConfirmButton:!1,timer:1700,timerProgressBar:!0,didOpen:d=>{d.addEventListener("mouseenter",n.stopTimer),d.addEventListener("mouseleave",n.resumeTimer)}});return(d,m)=>(L(),x(D,null,{title:e(()=>[o(" Delete Logs ")]),description:e(()=>[o(" Permanently delete all your logs. ")]),content:e(()=>[T,c("div",P,[t(f,{class:"py-3",onClick:_},{default:e(()=>[o(" Delete Logs ")]),_:1})]),t($,{show:l.value,onClose:i},{title:e(()=>[o(" Delete Logs ")]),content:e(()=>[o(" Are you sure you want to delete your logs? Once your logs is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your logs. "),c("div",A,[t(V,{ref_key:"passwordInput",ref:r,modelValue:a(s).password,"onUpdate:modelValue":m[0]||(m[0]=y=>a(s).password=y),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:k(u,["enter"])},null,8,["modelValue","onKeyup"]),t(b,{message:a(s).errors.password,class:"mt-2"},null,8,["message"])])]),footer:e(()=>[t(B,{onClick:i},{default:e(()=>[o(" Cancel ")]),_:1}),t(f,{class:C(["ml-3",{"opacity-25":a(s).processing}]),disabled:a(s).processing,onClick:u},{default:e(()=>[o(" Delete Logs ")]),_:1},8,["class","disabled"])]),_:1},8,["show"])]),_:1}))}};export{U as default};
