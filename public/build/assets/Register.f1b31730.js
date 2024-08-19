import{u as _,k as g,o as u,e as f,b as e,h as a,w as l,F as w,H as h,a as t,g as d,f as v,L as k,n as y,C as V}from"./app.1a19699e.js";import{A as b}from"./AuthenticationCard.5d3dc2ff.js";import{_ as x}from"./AuthenticationCardLogo.7f0988e7.js";import{_ as S}from"./Checkbox.8b9384ce.js";import{_ as m}from"./InputError.f27c5827.js";import{_ as i}from"./InputLabel.f099a4f5.js";import{_ as $}from"./PrimaryButton.5452ee96.js";import{_ as c}from"./TextInput.014f8b26.js";import"./_plugin-vue_export-helper.cdc0426e.js";const C=["onSubmit"],P={class:"mt-4"},q={class:"mt-4"},F={class:"mt-4"},N={key:0,class:"mt-4"},U={class:"flex items-center"},A={class:"ml-2"},E=["href"],L=["href"],B={class:"flex items-center justify-end mt-4"},K={__name:"Register",setup(M){const s=_({name:"",email:"",password:"",password_confirmation:"",terms:!1});g(()=>{localStorage.theme==="dark"||!("theme"in localStorage)&&window.matchMedia("(prefers-color-scheme: dark)").matches?(document.documentElement.classList.add("dark"),localStorage.theme="dark"):(document.documentElement.classList.remove("dark"),localStorage.theme="light")});const p=()=>{s.post(route("register"),{onFinish:()=>s.reset("password","password_confirmation")})};return(n,o)=>(u(),f(w,null,[e(a(h),{title:"Register"}),e(b,null,{logo:l(()=>[e(x)]),default:l(()=>[t("form",{onSubmit:V(p,["prevent"])},[t("div",null,[e(i,{for:"name",value:"Name"}),e(c,{id:"name",modelValue:a(s).name,"onUpdate:modelValue":o[0]||(o[0]=r=>a(s).name=r),type:"text",class:"mt-1 block w-full",required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"]),e(m,{class:"mt-2",message:a(s).errors.name},null,8,["message"])]),t("div",P,[e(i,{for:"email",value:"Email"}),e(c,{id:"email",modelValue:a(s).email,"onUpdate:modelValue":o[1]||(o[1]=r=>a(s).email=r),type:"email",class:"mt-1 block w-full",required:""},null,8,["modelValue"]),e(m,{class:"mt-2",message:a(s).errors.email},null,8,["message"])]),t("div",q,[e(i,{for:"password",value:"Password"}),e(c,{id:"password",modelValue:a(s).password,"onUpdate:modelValue":o[2]||(o[2]=r=>a(s).password=r),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"new-password"},null,8,["modelValue"]),e(m,{class:"mt-2",message:a(s).errors.password},null,8,["message"])]),t("div",F,[e(i,{for:"password_confirmation",value:"Confirm Password"}),e(c,{id:"password_confirmation",modelValue:a(s).password_confirmation,"onUpdate:modelValue":o[3]||(o[3]=r=>a(s).password_confirmation=r),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"new-password"},null,8,["modelValue"]),e(m,{class:"mt-2",message:a(s).errors.password_confirmation},null,8,["message"])]),n.$page.props.jetstream.hasTermsAndPrivacyPolicyFeature?(u(),f("div",N,[e(i,{for:"terms"},{default:l(()=>[t("div",U,[e(S,{id:"terms",checked:a(s).terms,"onUpdate:checked":o[4]||(o[4]=r=>a(s).terms=r),name:"terms",required:""},null,8,["checked"]),t("div",A,[d(" I agree to the "),t("a",{target:"_blank",href:n.route("terms.show"),class:"underline text-sm text-gray-600 hover:text-gray-900"},"Terms of Service",8,E),d(" and "),t("a",{target:"_blank",href:n.route("policy.show"),class:"underline text-sm text-gray-600 hover:text-gray-900"},"Privacy Policy",8,L)])]),e(m,{class:"mt-2",message:a(s).errors.terms},null,8,["message"])]),_:1})])):v("",!0),t("div",B,[e(a(k),{href:n.route("login"),class:"underline text-sm text-gray-600 hover:text-gray-900"},{default:l(()=>[d(" Already registered? ")]),_:1},8,["href"]),e($,{class:y(["ml-4",{"opacity-25":a(s).processing}]),disabled:a(s).processing},{default:l(()=>[d(" Register ")]),_:1},8,["class","disabled"])])],40,C)]),_:1})],64))}};export{K as default};