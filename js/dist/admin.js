(()=>{var e={n:t=>{var r=t&&t.__esModule?()=>t.default:()=>t;return e.d(r,{a:r}),r},d:(t,r)=>{for(var a in r)e.o(r,a)&&!e.o(t,a)&&Object.defineProperty(t,a,{enumerable:!0,get:r[a]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t),r:e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}},t={};(()=>{"use strict";e.r(t);const r=flarum.core.compat["admin/app"];var a=e.n(r);a().initializers.add("gm-fire/nexusphp-api",(function(){a().extensionData.for("gm-fire-nexusphp-api").registerSetting({setting:"nexusphp-api.secret",type:"text",label:a().translator.trans("gm-fire-nexusphp-api.admin.settings.secret")})}))})(),module.exports=t})();
//# sourceMappingURL=admin.js.map