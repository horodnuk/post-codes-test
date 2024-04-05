import{c as x,g as S,i as _,e as m,a as f,h as g,b as V,l as O,p as A,d as K,w as H,o as T,f as E,n as U,j as Y,k as F,m as Z,q as ee,r as b,s as I,t as W,u as R,v as L,x as te,y as ne,_ as oe,z as ie,A as le,B as q,C as re,D as ae,E as Q}from"./app-557641c9.js";const se=x({name:"QPage",props:{padding:Boolean,styleFn:Function},setup(t,{slots:h}){const{proxy:{$q:n}}=S(),e=_(O,m);if(e===m)return console.error("QPage needs to be a deep child of QLayout"),m;if(_(A,m)===m)return console.error("QPage needs to be child of QPageContainer"),m;const r=f(()=>{const c=(e.header.space===!0?e.header.size:0)+(e.footer.space===!0?e.footer.size:0);if(typeof t.styleFn=="function"){const l=e.isContainer.value===!0?e.containerHeight.value:n.screen.height;return t.styleFn(c,l)}return{minHeight:e.isContainer.value===!0?e.containerHeight.value-c+"px":n.screen.height===0?c!==0?`calc(100vh - ${c}px)`:"100vh":n.screen.height-c+"px"}}),s=f(()=>`q-page${t.padding===!0?" q-layout-padding":""}`);return()=>g("main",{class:s.value,style:r.value},V(h.default))}}),ce=x({name:"QPageContainer",setup(t,{slots:h}){const{proxy:{$q:n}}=S(),e=_(O,m);if(e===m)return console.error("QPageContainer needs to be child of QLayout"),m;K(A,!0);const a=f(()=>{const r={};return e.header.space===!0&&(r.paddingTop=`${e.header.size}px`),e.right.space===!0&&(r[`padding${n.lang.rtl===!0?"Left":"Right"}`]=`${e.right.size}px`),e.footer.space===!0&&(r.paddingBottom=`${e.footer.size}px`),e.left.space===!0&&(r[`padding${n.lang.rtl===!0?"Right":"Left"}`]=`${e.left.size}px`),r});return()=>g("div",{class:"q-page-container",style:a.value},V(h.default))}}),{passive:j}=F,ue=["both","horizontal","vertical"],de=x({name:"QScrollObserver",props:{axis:{type:String,validator:t=>ue.includes(t),default:"vertical"},debounce:[String,Number],scrollTarget:{default:void 0}},emits:["scroll"],setup(t,{emit:h}){const n={position:{top:0,left:0},direction:"down",directionChanged:!1,delta:{top:0,left:0},inflectionPoint:{top:0,left:0}};let e=null,a,r;H(()=>t.scrollTarget,()=>{l(),c()});function s(){e!==null&&e();const p=Math.max(0,Z(a)),w=ee(a),d={top:p-n.position.top,left:w-n.position.left};if(t.axis==="vertical"&&d.top===0||t.axis==="horizontal"&&d.left===0)return;const $=Math.abs(d.top)>=Math.abs(d.left)?d.top<0?"up":"down":d.left<0?"left":"right";n.position={top:p,left:w},n.directionChanged=n.direction!==$,n.delta=d,n.directionChanged===!0&&(n.direction=$,n.inflectionPoint=n.position),h("scroll",{...n})}function c(){a=Y(r,t.scrollTarget),a.addEventListener("scroll",i,j),i(!0)}function l(){a!==void 0&&(a.removeEventListener("scroll",i,j),a=void 0)}function i(p){if(p===!0||t.debounce===0||t.debounce==="0")s();else if(e===null){const[w,d]=t.debounce?[setTimeout(s,t.debounce),clearTimeout]:[requestAnimationFrame(s),cancelAnimationFrame];e=()=>{d(w),e=null}}}const{proxy:v}=S();return H(()=>v.$q.lang.rtl,s),T(()=>{r=v.$el.parentNode,c()}),E(()=>{e!==null&&e(),l()}),Object.assign(v,{trigger:i,getPosition:()=>n}),U}});function fe(){const t=b(!I.value);return t.value===!1&&T(()=>{t.value=!0}),t}const G=typeof ResizeObserver<"u",M=G===!0?{}:{style:"display:block;position:absolute;top:0;left:0;right:0;bottom:0;height:100%;width:100%;overflow:hidden;pointer-events:none;z-index:-1;",url:"about:blank"},N=x({name:"QResizeObserver",props:{debounce:{type:[String,Number],default:100}},emits:["resize"],setup(t,{emit:h}){let n=null,e,a={width:-1,height:-1};function r(l){l===!0||t.debounce===0||t.debounce==="0"?s():n===null&&(n=setTimeout(s,t.debounce))}function s(){if(n!==null&&(clearTimeout(n),n=null),e){const{offsetWidth:l,offsetHeight:i}=e;(l!==a.width||i!==a.height)&&(a={width:l,height:i},h("resize",a))}}const{proxy:c}=S();if(c.trigger=r,G===!0){let l;const i=v=>{e=c.$el.parentNode,e?(l=new ResizeObserver(r),l.observe(e),s()):v!==!0&&W(()=>{i(!0)})};return T(()=>{i()}),E(()=>{n!==null&&clearTimeout(n),l!==void 0&&(l.disconnect!==void 0?l.disconnect():e&&l.unobserve(e))}),U}else{let v=function(){n!==null&&(clearTimeout(n),n=null),i!==void 0&&(i.removeEventListener!==void 0&&i.removeEventListener("resize",r,F.passive),i=void 0)},p=function(){v(),e&&e.contentDocument&&(i=e.contentDocument.defaultView,i.addEventListener("resize",r,F.passive),s())};const l=fe();let i;return T(()=>{W(()=>{e=c.$el,e&&p()})}),E(v),()=>{if(l.value===!0)return g("object",{class:"q--avoid-card-border",style:M.style,tabindex:-1,type:"text/html",data:M.url,"aria-hidden":"true",onLoad:p})}}}}),he=x({name:"QLayout",props:{container:Boolean,view:{type:String,default:"hhh lpr fff",validator:t=>/^(h|l)h(h|r) lpr (f|l)f(f|r)$/.test(t.toLowerCase())},onScroll:Function,onScrollHeight:Function,onResize:Function},setup(t,{slots:h,emit:n}){const{proxy:{$q:e}}=S(),a=b(null),r=b(e.screen.height),s=b(t.container===!0?0:e.screen.width),c=b({position:0,direction:"down",inflectionPoint:0}),l=b(0),i=b(I.value===!0?0:R()),v=f(()=>"q-layout q-layout--"+(t.container===!0?"containerized":"standard")),p=f(()=>t.container===!1?{minHeight:e.screen.height+"px"}:null),w=f(()=>i.value!==0?{[e.lang.rtl===!0?"left":"right"]:`${i.value}px`}:null),d=f(()=>i.value!==0?{[e.lang.rtl===!0?"right":"left"]:0,[e.lang.rtl===!0?"left":"right"]:`-${i.value}px`,width:`calc(100% + ${i.value}px)`}:null);function $(o){if(t.container===!0||document.qScrollPrevented!==!0){const u={position:o.position.top,direction:o.direction,directionChanged:o.directionChanged,inflectionPoint:o.inflectionPoint.top,delta:o.delta.top};c.value=u,t.onScroll!==void 0&&n("scroll",u)}}function J(o){const{height:u,width:y}=o;let z=!1;r.value!==u&&(z=!0,r.value=u,t.onScrollHeight!==void 0&&n("scrollHeight",u),B()),s.value!==y&&(z=!0,s.value=y),z===!0&&t.onResize!==void 0&&n("resize",o)}function X({height:o}){l.value!==o&&(l.value=o,B())}function B(){if(t.container===!0){const o=r.value>l.value?R():0;i.value!==o&&(i.value=o)}}let C=null;const D={instances:{},view:f(()=>t.view),isContainer:f(()=>t.container),rootRef:a,height:r,containerHeight:l,scrollbarWidth:i,totalWidth:f(()=>s.value+i.value),rows:f(()=>{const o=t.view.toLowerCase().split(" ");return{top:o[0].split(""),middle:o[1].split(""),bottom:o[2].split("")}}),header:L({size:0,offset:0,space:!1}),right:L({size:300,offset:0,space:!1}),footer:L({size:0,offset:0,space:!1}),left:L({size:300,offset:0,space:!1}),scroll:c,animate(){C!==null?clearTimeout(C):document.body.classList.add("q-body--layout-animate"),C=setTimeout(()=>{C=null,document.body.classList.remove("q-body--layout-animate")},155)},update(o,u,y){D[o][u]=y}};if(K(O,D),R()>0){let y=function(){o=null,u.classList.remove("hide-scrollbar")},z=function(){if(o===null){if(u.scrollHeight>e.screen.height)return;u.classList.add("hide-scrollbar")}else clearTimeout(o);o=setTimeout(y,300)},P=function(k){o!==null&&k==="remove"&&(clearTimeout(o),y()),window[`${k}EventListener`]("resize",z)},o=null;const u=document.body;H(()=>t.container!==!0?"add":"remove",P),t.container!==!0&&P("add"),te(()=>{P("remove")})}return()=>{const o=ne(h.default,[g(de,{onScroll:$}),g(N,{onResize:J})]),u=g("div",{class:v.value,style:p.value,ref:t.container===!0?void 0:a,tabindex:-1},o);return t.container===!0?g("div",{class:"q-layout-container overflow-hidden",ref:a},[g(N,{onResize:X}),g("div",{class:"absolute-full",style:w.value},[g("div",{class:"scroll",style:d.value},[u])])]):u}}}),ve=ie({name:"DefaultLayout"});function ge(t,h,n,e,a,r){const s=re("router-view");return ae(),le(he,{class:"wrapper",view:"hhh lpR fff"},{default:q(()=>[Q(ce,{class:"full-width"},{default:q(()=>[Q(se,{padding:"",class:"content"},{default:q(()=>[Q(s)]),_:1})]),_:1})]),_:1})}const me=oe(ve,[["render",ge]]);export{me as default};
