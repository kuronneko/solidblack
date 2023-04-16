import{d,u as h,o as s,e as a,b as o,h as t,w as m,F as c,O as x,a as i,g as n,B as y,n as C,P as w}from"./app.abf1df1e.js";import{A as V}from"./AuthenticationCard.b7d39c55.js";import{_ as $}from"./AuthenticationCardLogo.a46ab7fa.js";import{_ as p}from"./InputError.85379217.js";import{_ as v}from"./InputLabel.bc6fa2f8.js";import{_ as B}from"./PrimaryButton.6c5775aa.js";import{_ as g}from"./TextInput.e6439ce1.js";import"./_plugin-vue_export-helper.cdc0426e.js";const F={class:"mb-4 text-sm text-gray-600"},I=["onSubmit"],T={key:0},U={key:1},N={class:"flex items-center justify-end mt-4"},P=["onClick"],q={__name:"TwoFactorChallenge",setup(A){const r=d(!1),e=h({code:"",recovery_code:""}),f=d(null),_=d(null),k=async()=>{r.value^=!0,await w(),r.value?(f.value.focus(),e.code=""):(_.value.focus(),e.recovery_code="")},b=()=>{e.post(route("two-factor.login"))};return(R,l)=>(s(),a(c,null,[o(t(x),{title:"Two-factor Confirmation"}),o(V,null,{logo:m(()=>[o($)]),default:m(()=>[i("div",F,[r.value?(s(),a(c,{key:1},[n(" Please confirm access to your account by entering one of your emergency recovery codes. ")],64)):(s(),a(c,{key:0},[n(" Please confirm access to your account by entering the authentication code provided by your authenticator application. ")],64))]),i("form",{onSubmit:y(b,["prevent"])},[r.value?(s(),a("div",U,[o(v,{for:"recovery_code",value:"Recovery Code"}),o(g,{id:"recovery_code",ref_key:"recoveryCodeInput",ref:f,modelValue:t(e).recovery_code,"onUpdate:modelValue":l[1]||(l[1]=u=>t(e).recovery_code=u),type:"text",class:"mt-1 block w-full",autocomplete:"one-time-code"},null,8,["modelValue"]),o(p,{class:"mt-2",message:t(e).errors.recovery_code},null,8,["message"])])):(s(),a("div",T,[o(v,{for:"code",value:"Code"}),o(g,{id:"code",ref_key:"codeInput",ref:_,modelValue:t(e).code,"onUpdate:modelValue":l[0]||(l[0]=u=>t(e).code=u),type:"text",inputmode:"numeric",class:"mt-1 block w-full",autofocus:"",autocomplete:"one-time-code"},null,8,["modelValue"]),o(p,{class:"mt-2",message:t(e).errors.code},null,8,["message"])])),i("div",N,[i("button",{type:"button",class:"text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer",onClick:y(k,["prevent"])},[r.value?(s(),a(c,{key:1},[n(" Use an authentication code ")],64)):(s(),a(c,{key:0},[n(" Use a recovery code ")],64))],8,P),o(B,{class:C(["ml-4",{"opacity-25":t(e).processing}]),disabled:t(e).processing},{default:m(()=>[n(" Log in ")]),_:1},8,["class","disabled"])])],40,I)]),_:1})],64))}};export{q as default};
