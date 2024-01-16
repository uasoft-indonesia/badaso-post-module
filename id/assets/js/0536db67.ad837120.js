"use strict";(self.webpackChunkdoc=self.webpackChunkdoc||[]).push([[220],{3905:function(t,e,a){a.d(e,{Zo:function(){return u},kt:function(){return g}});var n=a(7294);function i(t,e,a){return e in t?Object.defineProperty(t,e,{value:a,enumerable:!0,configurable:!0,writable:!0}):t[e]=a,t}function r(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),a.push.apply(a,n)}return a}function l(t){for(var e=1;e<arguments.length;e++){var a=null!=arguments[e]?arguments[e]:{};e%2?r(Object(a),!0).forEach((function(e){i(t,e,a[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):r(Object(a)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(a,e))}))}return t}function p(t,e){if(null==t)return{};var a,n,i=function(t,e){if(null==t)return{};var a,n,i={},r=Object.keys(t);for(n=0;n<r.length;n++)a=r[n],e.indexOf(a)>=0||(i[a]=t[a]);return i}(t,e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);for(n=0;n<r.length;n++)a=r[n],e.indexOf(a)>=0||Object.prototype.propertyIsEnumerable.call(t,a)&&(i[a]=t[a])}return i}var o=n.createContext({}),m=function(t){var e=n.useContext(o),a=e;return t&&(a="function"==typeof t?t(e):l(l({},e),t)),a},u=function(t){var e=m(t.components);return n.createElement(o.Provider,{value:e},t.children)},s={inlineCode:"code",wrapper:function(t){var e=t.children;return n.createElement(n.Fragment,{},e)}},k=n.forwardRef((function(t,e){var a=t.components,i=t.mdxType,r=t.originalType,o=t.parentName,u=p(t,["components","mdxType","originalType","parentName"]),k=m(a),g=i,c=k["".concat(o,".").concat(g)]||k[g]||s[g]||r;return a?n.createElement(c,l(l({ref:e},u),{},{components:a})):n.createElement(c,l({ref:e},u))}));function g(t,e){var a=arguments,i=e&&e.mdxType;if("string"==typeof t||i){var r=a.length,l=new Array(r);l[0]=k;var p={};for(var o in e)hasOwnProperty.call(e,o)&&(p[o]=e[o]);p.originalType=t,p.mdxType="string"==typeof t?t:i,l[1]=p;for(var m=2;m<r;m++)l[m]=a[m];return n.createElement.apply(null,l)}return n.createElement.apply(null,a)}k.displayName="MDXCreateElement"},1924:function(t,e,a){a.r(e),a.d(e,{frontMatter:function(){return p},contentTitle:function(){return o},metadata:function(){return m},toc:function(){return u},default:function(){return k}});var n=a(7462),i=a(3366),r=(a(7294),a(3905)),l=["components"],p={sidebar_position:2},o="Penyiapan Google Analytics",m={unversionedId:"getting-started/google-analytics-setup",id:"getting-started/google-analytics-setup",title:"Penyiapan Google Analytics",description:"Mendapatkan kredensial JSON",source:"@site/i18n/id/docusaurus-plugin-content-docs/current/getting-started/google-analytics-setup.md",sourceDirName:"getting-started",slug:"/getting-started/google-analytics-setup",permalink:"/id/getting-started/google-analytics-setup",editUrl:"https://github.com/uasoft-indonesia/badaso-post-module/edit/main/website/docs/getting-started/google-analytics-setup.md",tags:[],version:"current",sidebarPosition:2,frontMatter:{sidebar_position:2},sidebar:"tutorialSidebar",previous:{title:"Installation",permalink:"/id/getting-started/installation"},next:{title:"Override Controller",permalink:"/id/customization/override-controller"}},u=[{value:"Mendapatkan kredensial JSON",id:"mendapatkan-kredensial-json",children:[],level:2},{value:"Memberikan izin ke properti Analytics Anda",id:"memberikan-izin-ke-properti-analytics-anda",children:[],level:2},{value:"Mendapatkan ID yang Anda butuhkan.",id:"mendapatkan-id-yang-anda-butuhkan",children:[{value:"ID Akun",id:"id-akun",children:[],level:3},{value:"Property ID / View ID",id:"property-id--view-id",children:[],level:3}],level:2},{value:"Tracking ID",id:"tracking-id",children:[{value:"Web Property ID",id:"web-property-id",children:[],level:3}],level:2}],s={toc:u};function k(t){var e=t.components,a=(0,i.Z)(t,l);return(0,r.kt)("wrapper",(0,n.Z)({},s,a,{components:e,mdxType:"MDXLayout"}),(0,r.kt)("h1",{id:"penyiapan-google-analytics"},"Penyiapan Google Analytics"),(0,r.kt)("h2",{id:"mendapatkan-kredensial-json"},"Mendapatkan kredensial JSON"),(0,r.kt)("ol",null,(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Kunjungi situs  ",(0,r.kt)("a",{parentName:"p",href:"https://console.cloud.google.com/"},"Google API\u2019s site")," menggunakan akun google anda dan pilih atau buat sebuah projek baru .\n",(0,r.kt)("img",{parentName:"p",src:"https://i.imgur.com/PuMoMVM.png",alt:"Imgur"}))),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},'Atur projek API. Klik menu Library dan cari kata kunci "Google Analytics Data API".\n',(0,r.kt)("img",{parentName:"p",src:"https://i.imgur.com/5hCgMnF.png",alt:"Imgur"}),"\n",(0,r.kt)("img",{parentName:"p",src:"https://imgur.com/PEtz6sk.png",alt:"Imgur"}))),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Pilih aktifkan untuk mengaktifkan API.\n",(0,r.kt)("img",{parentName:"p",src:"https://imgur.com/JshNpEh.png",alt:"Imgur"}))),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Jika Anda belum memiliki akun Analytics sebelumnya, isi form seperti gambar di bawah ini."),(0,r.kt)("ul",{parentName:"li"},(0,r.kt)("li",{parentName:"ul"},"Kunjungi situs ",(0,r.kt)("a",{parentName:"li",href:"https://analytics.google.com/analytics/web"},"Analytics site"),". Isikan nama akun\n",(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/yS7HV3P.png",alt:"Imgur"})),(0,r.kt)("li",{parentName:"ul"},"Isi nama properti, zona waktu pelaporan, dan mata uang.\n",(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/UEIJOK3.png",alt:"Imgur"})),(0,r.kt)("li",{parentName:"ul"},"Periksa apa pun tentang bisnis Anda.\n",(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/6Rd3FIe.png",alt:"Imgur"})),(0,r.kt)("li",{parentName:"ul"},"Periksa apa pun yang menjadi tujuan bisnis Anda.\n",(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/jStlyFx.png",alt:"Imgur"})),(0,r.kt)("li",{parentName:"ul"},"Pilih pengumpulan data untuk mendapatkan ID Pelacakan Analytics\n",(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/bCG7FTx.png",alt:"Imgur"})))),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Kunjungi situs ",(0,r.kt)("a",{parentName:"p",href:"https://console.cloud.google.com/apis/dashboard"},"Google API")," dan pilih proyek yang Anda inginkan dari header.")),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Kunjungi situs ",(0,r.kt)("a",{parentName:"p",href:"https://console.cloud.google.com/apis/credentials"},"Credential")," dan membuat kredensial baru.Click ",(0,r.kt)("strong",{parentName:"p"},"Create Credentials")," dan pilih ",(0,r.kt)("strong",{parentName:"p"},"Service account"),"."))),(0,r.kt)("p",null,(0,r.kt)("img",{parentName:"p",src:"https://i.imgur.com/nS7m6rZ.png",alt:"Imgur"})),(0,r.kt)("ol",null,(0,r.kt)("li",{parentName:"ol"},"Isi form dengan nama akun layanan dan ID akun yang Anda sukai. Setelah itu, klik tombol ",(0,r.kt)("strong",{parentName:"li"},"Buat")," dan klik ",(0,r.kt)("strong",{parentName:"li"},"Selesai"),".")),(0,r.kt)("p",null,(0,r.kt)("img",{parentName:"p",src:"https://i.imgur.com/PhCaP9Z.png",alt:"Imgur"})),(0,r.kt)("ol",null,(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Untuk mendapatkan kredensial akun layanan JSON, tekan edit pada akun layanan yang baru dibuat.\n",(0,r.kt)("img",{parentName:"p",src:"https://i.imgur.com/pXbDdHy.png",alt:"Imgur"}))),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Pilih menu ",(0,r.kt)("strong",{parentName:"p"},"KUNCI")," dari tab. Klik Tambahkan Kunci dan pilih ",(0,r.kt)("strong",{parentName:"p"},"Buat kunci baru"),". Setelah itu, pilih JSON dan klik tombol ",(0,r.kt)("strong",{parentName:"p"},"Buat"),".\n",(0,r.kt)("img",{parentName:"p",src:"https://i.imgur.com/oexLid9.png",alt:"Imgur"}))),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Setelah Anda membuat kunci, kunci tersebut akan diunduh secara otomatis.")),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Tempatkan kunci .json Anda ke direktori penyimpanan seperti di bawah ini."))),(0,r.kt)("pre",null,(0,r.kt)("code",{parentName:"pre",className:"language-php"},"\ud83d\udce6 Your Project\n \u2523 \ud83d\udcc2 storage\n \u2503 \u2523 \ud83d\udcc2 app\n \u2503 \u2503 \u2523 \ud83d\udcc2 analytics // If the directory doesn't exists, just create it\n \u2503 \u2503 \u2503 \u2517 \ud83d\udcdc service-account-credentials.json // Filename must be the same\n")),(0,r.kt)("h2",{id:"memberikan-izin-ke-properti-analytics-anda"},"Memberikan izin ke properti Analytics Anda"),(0,r.kt)("ol",null,(0,r.kt)("li",{parentName:"ol"},"Kunjungi situs ",(0,r.kt)("a",{parentName:"li",href:"http://analytics.google.com/"},"Google Analytics")," page."),(0,r.kt)("li",{parentName:"ol"},"Pilih menu ",(0,r.kt)("strong",{parentName:"li"},"Admin")," dari sidebar. Pilih Manajemen akses properti\n",(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/chIY1ov.png",alt:"Imgur"}),(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/HlnzQmw.png",alt:"Imgur"})),(0,r.kt)("li",{parentName:"ol"},"Akan muncul jendela baru, setelah itu klik ",(0,r.kt)("strong",{parentName:"li"},"Tambahkan pengguna"),".\n",(0,r.kt)("img",{parentName:"li",src:"https://i.imgur.com/BCVGUH4.png",alt:"Imgur"})),(0,r.kt)("li",{parentName:"ol"},"Buka kredensial yang kita dapatkan sebelumnya, cari ",(0,r.kt)("inlineCode",{parentName:"li"},"client_email"),". Salin emailnya.\n",(0,r.kt)("img",{parentName:"li",src:"https://i.imgur.com/A7CPWQB.png",alt:"Imgur"})),(0,r.kt)("li",{parentName:"ol"},"Tempelkan di kolom ",(0,r.kt)("strong",{parentName:"li"},"Alamat email")," dan pilih izin yang Anda inginkan. ",(0,r.kt)("strong",{parentName:"li"},"Anda harus memeriksa izin Penampil"),". Setelah itu, tekan tombol ",(0,r.kt)("strong",{parentName:"li"},"Selesai"),".\n",(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/ms314Ek.png",alt:"Imgur"}))),(0,r.kt)("h2",{id:"mendapatkan-id-yang-anda-butuhkan"},"Mendapatkan ID yang Anda butuhkan."),(0,r.kt)("h3",{id:"id-akun"},"ID Akun"),(0,r.kt)("ol",null,(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Pilih menu Admin dari sidebar dan pilih Detail Akun.\n",(0,r.kt)("img",{parentName:"p",src:"https://imgur.com/FXzIwrL.png",alt:"Imgur"}))),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Itu dia.\n",(0,r.kt)("img",{parentName:"p",src:"https://imgur.com/g0cv2if.png",alt:"Imgur"})))),(0,r.kt)("h3",{id:"property-id--view-id"},"Property ID / View ID"),(0,r.kt)("ol",null,(0,r.kt)("li",{parentName:"ol"},"Pilih menu Admin dari sidebar dan pilih Detail Properti. Itu dia.\n",(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/eELpvws.png",alt:"Imgur"}))),(0,r.kt)("h2",{id:"tracking-id"},"Tracking ID"),(0,r.kt)("ol",null,(0,r.kt)("li",{parentName:"ol"},"Buka menu Beranda Analytics. Itu dia.\n",(0,r.kt)("img",{parentName:"li",src:"https://imgur.com/LByg6fc.png",alt:"Imgur"}))),(0,r.kt)("h3",{id:"web-property-id"},"Web Property ID"),(0,r.kt)("ol",null,(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Buka halaman ",(0,r.kt)("a",{parentName:"p",href:"http://analytics.google.com/"},"Google Analytics"),".")),(0,r.kt)("li",{parentName:"ol"},(0,r.kt)("p",{parentName:"li"},"Lihatlah URL halaman. ID properti web dimulai dengan ",(0,r.kt)("strong",{parentName:"p"},"p"),". Biasanya memiliki 9 karakter. Misalnya:\n",(0,r.kt)("a",{parentName:"p",href:"https://analytics.google.com/analytics/web/#/p299999997/reports/intelligenthome"},"https://analytics.google.com/analytics/web/#/p299999997/reports/intelligenthome")),(0,r.kt)("p",{parentName:"li"},"   ID properti web untuk akun tersebut adalah 299999997."))),(0,r.kt)("p",null,(0,r.kt)("img",{parentName:"p",src:"https://imgur.com/sW8ZBda.png",alt:"Imgur"})))}k.isMDXComponent=!0}}]);