!function(){"use strict";var e=wp.components.CheckboxControl,t=function(t){var a=t.listItems,n=t.selected,l=t.onItemChange,o=t.label;return wp.element.createElement("div",{className:"components-base-control"},wp.element.createElement("label",{class:"components-base-control__label"},o),wp.element.createElement("ul",{className:"multibox__checklist"},a.map((function(t){return wp.element.createElement("li",{key:t.value,className:"multibox__checklist-item"},wp.element.createElement(e,{label:t.label,checked:n.includes(t.value),onChange:function(){l(t.value)}}))}))))},a=wp.components.CheckboxControl,n=function(e){var t=e.listItems,n=e.selected,l=e.onItemChange,o=e.label;return wp.element.createElement("div",{className:"components-base-control"},wp.element.createElement("label",{class:"components-base-control__label"},o),wp.element.createElement("ul",{className:"multibox__checklist"},t.map((function(e){return wp.element.createElement("li",{key:e.value,className:"multibox__checklist-item"},wp.element.createElement(a,{label:(t=e.label,o=document.createElement("textarea"),o.innerHTML=t,o.value),checked:n.includes(e.value),onChange:function(){l(e.value)},disabled:n.includes("")&&""!==e.value,className:n.includes("")&&""!==e.value?"checkbox-disabled":""}));var t,o}))))};function l(e){return(l="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function o(e){return function(e){if(Array.isArray(e))return r(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(e){if("string"==typeof e)return r(e,t);var a=Object.prototype.toString.call(e).slice(8,-1);return"Object"===a&&e.constructor&&(a=e.constructor.name),"Map"===a||"Set"===a?Array.from(e):"Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)?r(e,t):void 0}}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function r(e,t){(null==t||t>e.length)&&(t=e.length);for(var a=0,n=new Array(t);a<t;a++)n[a]=e[a];return n}function i(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}function s(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function c(e,t){for(var a=0;a<t.length;a++){var n=t[a];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function p(e,t){return(p=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function u(e,t){return!t||"object"!==l(t)&&"function"!=typeof t?d(e):t}function d(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}function m(e){return(m=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}var h=wp.i18n.__,f=wp.element,y=f.Component,b=f.Fragment,g=wp.editor,v=g.MediaUpload,w=g.PanelColorSettings,E=wp.apiFetch,C=wp.components,S=C.Dashicon,k=C.SelectControl,x=C.PanelBody,L=C.Button,P=C.Disabled,T=C.Placeholder,_=C.RangeControl,D=C.TextControl,F=C.TextareaControl,R=C.ToggleControl,M=C.Toolbar,U=wp.serverSideRender,O=wp.blockEditor,A=O.BlockControls,B=O.InspectorControls,N=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&p(e,t)}(g,e);var a,l,r,f,y=(r=g,f=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=m(r);if(f){var a=m(this).constructor;e=Reflect.construct(t,arguments,a)}else e=t.apply(this,arguments);return u(this,e)});function g(){var e;s(this,g);var t=!(e=y.apply(this,arguments)).props.attributes.feedURL&&"feed"===e.props.attributes.fetchMethod||!e.props.attributes.audioSrc&&"link"===e.props.attributes.fetchMethod;e.state={editing:t,fontFamilies:[],postTypes:[],taxonomies:[],termsList:[],episodeList:[],seasonList:[],categoryList:[]};var a=window.ppmejsSettings||{};return e.isPremium=a.isPremium,e.fetching=!1,e.toggleAttribute=e.toggleAttribute.bind(d(e)),e.onSubmitURL=e.onSubmitURL.bind(d(e)),e}return a=g,(l=[{key:"apiDataFetch",value:function(e,t){var a=this;this.fetching?setTimeout(this.apiDataFetch.bind(this,e,t),200):(this.fetching=!0,E({path:"/podcastplayer/v1/"+t}).then((function(t){var n=Object.keys(t);n=n.map((function(e){return{label:t[e],value:e}})),a.setState(i({},e,n)),a.fetching=!1,"episodeList"==e&&console.log(n)})).catch((function(t){a.setState(i({},e,[])),a.fetching=!1,console.log(t)})))}},{key:"componentDidMount",value:function(){if(this.isPremium){var e=this.props.attributes,t=e.postType,a=e.fetchMethod;this.apiDataFetch("postTypes","posttypes"),this.apiDataFetch("fontFamilies","fontfamily"),"link"!==a&&this.updateElist(),"feed"===a&&(this.updateSlist(),this.updateCatlist()),t&&(this.updateTaxonomy(),this.updateTerms())}}},{key:"componentDidUpdate",value:function(e){if(this.isPremium){var t=e.attributes,a=t.postType,n=t.taxonomy,l=t.fontFamily,o=t.terms,r=t.sortBy,i=t.filterBy,s=t.fetchMethod,c=t.feedURL,p=t.catlist,u=t.slist,d=this.props.attributes,m=d.postType,h=d.taxonomy,f=d.fontFamily,y=d.terms,b=d.sortBy,g=d.filterBy,v=d.fetchMethod,w=d.feedURL,E=d.slist,C=d.catlist;a!==m&&this.updateTaxonomy(),n!==h&&this.updateTerms(),l!==f&&this.updateFonts(),n===h&&o===y&&r===b&&i===g&&s===v&&c===w&&p===C&&u===E||this.updateElist(),(s!==v&&"feed"===v||c!==w)&&(this.updateSlist(),this.updateCatlist())}}},{key:"updateTaxonomy",value:function(){var e=this.props.attributes.postType;e?this.apiDataFetch("taxonomies","taxonomies/"+e):this.setState({taxonomies:[],termsList:[]})}},{key:"updateTerms",value:function(){var e=this.props.attributes.taxonomy;e?this.apiDataFetch("termsList","terms/"+e):this.setState({termsList:[]})}},{key:"updateElist",value:function(){var e=this.props.attributes,t=e.fetchMethod,a=e.feedURL,n=e.postType,l=e.taxonomy,o=e.terms,r=e.sortBy,i=e.filterBy,s=e.slist,c=e.catlist;if("feed"===t&&""!==a){var p="",u=!!s&&s.filter(Boolean),d=!!c&&c.filter(Boolean);u&&u.length&&(p+="&seasons="+u.join()),d&&d.length&&(p+="&categories="+d.join()),this.apiDataFetch("episodeList","fElist?feedURL="+encodeURIComponent(a)+p)}else if("post"===t){var m="";l&&o&&o.length&&(m+="&taxonomy="+l+"&terms="+o.join()),r&&(m+="&sortBy="+r),i&&(m+="&filterBy="+i),this.apiDataFetch("episodeList","pElist?postType="+n+m)}else this.setState({episodeList:[]})}},{key:"updateSlist",value:function(){var e=this.props.attributes,t=e.fetchMethod,a=e.feedURL;"feed"===t&&""!==a?this.apiDataFetch("seasonList","fSlist?feedURL="+a):this.setState({seasonList:[]})}},{key:"updateCatlist",value:function(){var e=this.props.attributes,t=e.fetchMethod,a=e.feedURL;"feed"===t&&""!==a?this.apiDataFetch("categoryList","fcatlist?feedURL="+a):this.setState({categoryList:[]})}},{key:"updateFonts",value:function(){var e=this.props.attributes.fontFamily,t=this.state.fontFamilies;if(e){var a=t.filter((function(t){return e===t.value}));if(a.length){var n=a[0].label.split(" ").join("+");if(0===jQuery("link#podcast-player-fonts-css-temp").length){var l=jQuery("<link>",{id:"podcast-player-fonts-css-temp",href:"//fonts.googleapis.com/css?family="+n,rel:"stylesheet",type:"text/css"});jQuery("link:last").after(l)}else{var o=jQuery("link#podcast-player-fonts-css-temp"),r=o.attr("href");o.attr("href",r+"%7C"+n)}}}}},{key:"toggleAttribute",value:function(e){var t=this;return function(){var a=t.props.attributes[e];(0,t.props.setAttributes)(i({},e,!a))}}},{key:"onSubmitURL",value:function(e){e.preventDefault();var t=this.props.attributes,a=t.fetchMethod,n=t.feedURL,l=t.audioSrc;"feed"===a?n&&this.setState({editing:!1}):"link"===a&&l&&this.setState({editing:!1})}},{key:"navMenuSelect",value:function(){var e=window.podcastPlayerData.menu||{};return(e=Array.from(e)).push({label:"- Select Menu -",value:""}),e.map((function(e){return{label:e.label,value:e.value}}))}},{key:"render",value:function(){var e=this,a=this.props.attributes,l=a.feedURL,r=a.sortBy,i=a.filterBy,s=a.number,c=a.excerptLength,p=a.excerptUnit,u=a.podcastMenu,d=a.coverImage,m=a.description,f=a.accentColor,y=a.displayStyle,g=a.aspectRatio,E=a.cropMethod,C=a.gridColumns,O=a.fetchMethod,N=a.postType,I=a.taxonomy,H=a.terms,j=a.podtitle,q=a.audioSrc,z=a.audioTitle,Q=a.audioLink,G=a.headerDefault,V=a.listDefault,W=a.hideHeader,$=a.hideTitle,J=a.hideCover,K=a.hideDesc,X=a.hideSubscribe,Y=a.hideSearch,Z=a.hideAuthor,ee=a.hideContent,te=a.hideLoadmore,ae=a.hideDownload,ne=a.ahideDownload,le=a.hideSocial,oe=a.hideFeatured,re=a.ahideSocial,ie=a.audioMsg,se=a.playFreq,ce=a.msgStart,pe=a.msgTime,ue=a.msgText,de=a.bgColor,me=a.txtColor,he=a.fontFamily,fe=a.appleSub,ye=a.googleSub,be=a.spotifySub,ge=a.elist,ve=a.slist,we=a.catlist,Ee=a.edisplay,Ce=this.state,Se=Ce.postTypes,ke=Ce.taxonomies,xe=Ce.termsList,Le=Ce.episodeList,Pe=Ce.seasonList,Te=Ce.categoryList,_e=Ce.fontFamilies,De=this.props.setAttributes,Fe=this.navMenuSelect(),Re=window.podcastPlayerData.style||{label:"Default",value:""},Me=function(e,t){var a=window.podcastPlayerData.stSup||!1;return!(void 0===y||!a)&&!!a[e]&&a[e].includes(t)},Ue=[{value:"",label:h("No Cropping","podcast-player")},{value:"land1",label:h("Landscape (4:3)","podcast-player")},{value:"land2",label:h("Landscape (3:2)","podcast-player")},{value:"port1",label:h("Portrait (3:4)","podcast-player")},{value:"port2",label:h("Portrait (2:3)","podcast-player")},{value:"wdscrn",label:h("Widescreen (16:9)","podcast-player")},{value:"squr",label:h("Square (1:1)","podcast-player")}],Oe=[{value:"topleftcrop",label:h("Top Left Cropping","podcast-player")},{value:"topcentercrop",label:h("Top Center Cropping","podcast-player")},{value:"centercrop",label:h("Center Cropping","podcast-player")},{value:"bottomcentercrop",label:h("Bottom Center Cropping","podcast-player")},{value:"bottomleftcrop",label:h("Bottom Left Cropping","podcast-player")}],Ae=function(t){De({fetchMethod:t,elist:[""],slist:[""],catlist:[""],edisplay:""}),"post"===t?e.setState({editing:!1}):e.setState({editing:!0})};if(this.state.editing)return wp.element.createElement(b,null,wp.element.createElement(T,{icon:"rss",label:"RSS"},wp.element.createElement("form",{onSubmit:this.onSubmitURL},"feed"===O&&wp.element.createElement(D,{placeholder:h("Enter URL here…","podcast-player"),value:l,onChange:function(e){return De({feedURL:e,elist:[""],slist:[""],catlist:[""],edisplay:""})},className:"components-placeholder__input"}),"link"===O&&wp.element.createElement(D,{placeholder:h("Enter Audio/Video Link (i.e, mp3, ogg, m4a etc.)","podcast-player"),value:q,onChange:function(e){return De({audioSrc:e})},className:"components-placeholder__input"}),wp.element.createElement(L,{isLarge:!0,type:"submit"},h("Use URL","podcast-player")))),wp.element.createElement(B,null,!!this.isPremium&&wp.element.createElement(x,{initialOpen:!0,title:h("Setup Fetching Method","podcast-player")},wp.element.createElement(k,{label:h("Fetch Podcast Episodes","podcast-player"),value:O,onChange:Ae,options:[{value:"feed",label:h("from Feed","podcast-player")},{value:"post",label:h("from Post","podcast-player")},{value:"link",label:h("from Audio/Video URL","podcast-player")}]}))));var Be=[{icon:"edit",title:h("Edit RSS URL","podcast-player"),onClick:function(){return e.setState({editing:!0})}}];return wp.element.createElement(b,null,wp.element.createElement(A,null,wp.element.createElement(M,{controls:Be})),wp.element.createElement(B,null,!!this.isPremium&&wp.element.createElement(x,{initialOpen:!0,title:h("Setup Fetching Method","podcast-player")},wp.element.createElement(k,{label:h("Fetch Podcast Episodes","podcast-player"),value:O,onChange:Ae,options:[{value:"feed",label:h("from Feed","podcast-player")},{value:"post",label:h("from Post","podcast-player")},{value:"link",label:h("from Audio/Video URL","podcast-player")}]}),Se&&"post"===O&&wp.element.createElement(k,{label:h("Select Post Type","podcast-player"),value:N,options:Se,onChange:function(e){return function(e){De({terms:[]}),De({taxonomy:""}),De({postType:e})}(e)}}),N&&!!ke.length&&"post"===O&&wp.element.createElement(k,{label:h("Get items by Taxonomy","podcast-player"),value:I,options:ke,onChange:function(e){return function(e){De({terms:[]}),De({taxonomy:e})}(e)}}),!!xe.length&&"post"===O&&wp.element.createElement(t,{listItems:xe,selected:H,onItemChange:function(e){var t=H.indexOf(e);De(-1===t?{terms:[].concat(o(H),[e])}:{terms:H.filter((function(t){return t!==e}))})},label:h("Select Taxonomy Terms","podcast-player")}),"link"===O&&wp.element.createElement(D,{label:h("Episode Title","podcast-player"),value:z,onChange:function(e){return De({audioTitle:e})}}),"link"===O&&wp.element.createElement(D,{label:h("Podcast episode link for social sharing (optional)","podcast-player"),value:Q,onChange:function(e){return De({audioLink:e})}}),"link"===O&&wp.element.createElement(R,{label:h("Hide Episode Download Link","podcast-player"),checked:!!ne,onChange:function(e){return De({ahideDownload:e})}}),"link"===O&&wp.element.createElement(R,{label:h("Hide Social Share Links","podcast-player"),checked:!!re,onChange:function(e){return De({ahideSocial:e})}})),wp.element.createElement(x,{initialOpen:!1,title:h("Change Podcast Content","podcast-player")},this.isPremium&&"post"===O&&wp.element.createElement(D,{label:h("Podcast Title","podcast-player"),value:j,onChange:function(e){return De({podtitle:e})}}),wp.element.createElement(v,{onSelect:function(e){return De({coverImage:e.url})},type:"image",value:d,render:function(e){var t=e.open;return wp.element.createElement(L,{className:"pp-cover-btn",onClick:t},d?wp.element.createElement("img",{className:"ppe-cover-image",src:d,alt:h("Cover Image","podcast-player")}):wp.element.createElement("div",{className:"no-image"},wp.element.createElement(S,{icon:"format-image"}),h("Upload Cover Image","podcast-player")))}}),d&&wp.element.createElement(L,{className:"remove-pp-cover",onClick:function(){return De({coverImage:""})}},h("Remove Cover Image","podcast-player")),wp.element.createElement(F,{label:h("Brief Description","podcast-player"),help:h("Change Default Podcast Description","podcast-player"),value:m,onChange:function(e){return De({description:e})}}),"link"!==O&&wp.element.createElement(_,{label:h("Number of episodes to show at a time","podcast-player"),value:s,onChange:function(e){return De({number:e})},min:1,max:100}),Me(y,"excerpt")&&wp.element.createElement(_,{label:h("Excerpt Length","podcast-player"),value:c,onChange:function(e){return De({excerptLength:e})},min:0,max:200}),Me(y,"excerpt")&&wp.element.createElement(k,{label:h("Excerpt Length Unit","podcast-player"),value:p,onChange:function(e){return De({excerptUnit:e})},options:[{value:"",label:h("Number of words","podcast-player")},{value:"char",label:h("Number of characters","podcast-player")}]}),wp.element.createElement(D,{label:h("Apple Podcast Subscription link","podcast-player"),value:fe,onChange:function(e){return De({appleSub:e})}}),wp.element.createElement(D,{label:h("Google Podcast Subscription link","podcast-player"),value:ye,onChange:function(e){return De({googleSub:e})}}),wp.element.createElement(D,{label:h("Spotify Podcast Subscription link","podcast-player"),value:be,onChange:function(e){return De({spotifySub:e})}}),wp.element.createElement(k,{label:h("Custom menu for more subscription links","podcast-player"),value:u,onChange:function(e){return De({podcastMenu:e})},options:Fe})),"link"!==O&&wp.element.createElement(x,{initialOpen:!1,title:h("Show/Hide Player Items","podcast-player")},(!y||"legacy"===y)&&wp.element.createElement(R,{label:h("Show Podcast Header by Default","podcast-player"),checked:!!G,onChange:function(e){return De({headerDefault:e})}}),(!y||"legacy"===y)&&wp.element.createElement(R,{label:h("Show episodes list by default on mini player.","podcast-player"),checked:!!V,onChange:function(e){return De({listDefault:e})}}),wp.element.createElement(R,{label:h("Hide Podcast Header","podcast-player"),checked:!!W,onChange:function(e){return De({hideHeader:e})}}),!W&&wp.element.createElement(R,{label:h("Hide cover image","podcast-player"),checked:!!J,onChange:function(e){return De({hideCover:e})}}),!W&&wp.element.createElement(R,{label:h("Hide Podcast Title","podcast-player"),checked:!!$,onChange:function(e){return De({hideTitle:e})}}),!W&&wp.element.createElement(R,{label:h("Hide Podcast Description","podcast-player"),checked:!!K,onChange:function(e){return De({hideDesc:e})}}),!W&&wp.element.createElement(R,{label:h("Hide Custom menu","podcast-player"),checked:!!X,onChange:function(e){return De({hideSubscribe:e})}}),wp.element.createElement(R,{label:h("Hide Podcast Search","podcast-player"),checked:!!Y,onChange:function(e){return De({hideSearch:e})}}),wp.element.createElement(R,{label:h("Hide Episode Author/Podcaster Name","podcast-player"),checked:!!Z,onChange:function(e){return De({hideAuthor:e})}}),"feed"===O&&wp.element.createElement(R,{label:h("Hide Episode Text Content/Transcript","podcast-player"),checked:!!ee,onChange:function(e){return De({hideContent:e})}}),wp.element.createElement(R,{label:h("Hide Load More Episodes Button","podcast-player"),checked:!!te,onChange:function(e){return De({hideLoadmore:e})}}),wp.element.createElement(R,{label:h("Hide Episode Download Link","podcast-player"),checked:!!ae,onChange:function(e){return De({hideDownload:e})}}),wp.element.createElement(R,{label:h("Hide Social Share Links","podcast-player"),checked:!!le,onChange:function(e){return De({hideSocial:e})}}),wp.element.createElement(R,{label:h("Hide Episodes Featured Image","podcast-player"),checked:!!oe,onChange:function(e){return De({hideFeatured:e})}})),wp.element.createElement(x,{initialOpen:!1,title:h("Podcast Player Styling","podcast-player")},wp.element.createElement(k,{label:h("Podcast Player Display Style","podcast-player"),value:y,onChange:function(e){return De({displayStyle:e})},options:Re}),Me(y,"thumbnail")&&wp.element.createElement(k,{label:h("Thumbnail Cropping","podcast-player"),value:g,onChange:function(e){return De({aspectRatio:e})},options:Ue}),Me(y,"thumbnail")&&g&&wp.element.createElement(k,{label:h("Thumbnail Cropping Position","podcast-player"),value:E,onChange:function(e){return De({cropMethod:e})},options:Oe}),Me(y,"grid")&&wp.element.createElement(_,{label:h("Grid Columns","podcast-player"),value:C,onChange:function(e){return De({gridColumns:e})},min:2,max:6}),!!this.isPremium&&wp.element.createElement(k,{label:h("Select Font Family","podcast-player"),value:he,options:_e,onChange:function(e){return De({fontFamily:e})}}),!!this.isPremium&&Me(y,"txtcolor")&&wp.element.createElement(k,{label:h("Text Color Scheme","podcast-player"),value:me,options:[{value:"",label:h("Dark Text","podcast-player")},{value:"ltext",label:h("Light Text","podcast-player")}],onChange:function(e){return De({txtColor:e})}})),wp.element.createElement(w,{title:h("Podcast Player Color Scheme","podcast-player"),initialOpen:!1,colorSettings:[{value:f,onChange:function(e){return De({accentColor:e})},label:h("Accent Color","podcast-player")}].concat(o(this.isPremium&&Me(y,"bgcolor")?[{value:de,onChange:function(e){return De({bgColor:e})},label:h("Player Background Color","podcast-player")}]:[]))}),"link"!==O&&wp.element.createElement(x,{initialOpen:!1,title:h("Sort & Filter Options","podcast-player")},wp.element.createElement(k,{label:h("Sort Podcast Episodes By","podcast-player"),value:r,onChange:function(e){return De({sortBy:e})},options:[{value:"sort_title_desc",label:h("Title Descending","podcast-player")},{value:"sort_title_asc",label:h("Title Ascending","podcast-player")},{value:"sort_date_desc",label:h("Date Descending","podcast-player")},{value:"sort_date_asc",label:h("Date Ascending","podcast-player")}]}),wp.element.createElement(D,{label:h("Show episodes only if title contains following","podcast-player"),value:i,onChange:function(e){return De({filterBy:e})}}),1<Pe.length&&"feed"===O&&wp.element.createElement(n,{listItems:Pe,selected:ve,onItemChange:function(e){var t=ve.indexOf(e);De(-1===t?""===e?{slist:[e]}:{slist:[].concat(o(ve),[e])}:""===e?{slist:[]}:{slist:ve.filter((function(t){return t!==e}))})},label:h("Select Seasons to be displayed","podcast-player")}),1<Te.length&&"feed"===O&&wp.element.createElement(n,{listItems:Te,selected:we,onItemChange:function(e){var t=we.indexOf(e);De(-1===t?""===e?{catlist:[e]}:{catlist:[].concat(o(we),[e])}:""===e?{catlist:[]}:{catlist:we.filter((function(t){return t!==e}))})},label:h("Select Categories to be displayed","podcast-player")}),!!Le.length&&"link"!==O&&wp.element.createElement(n,{listItems:Le,selected:ge,onItemChange:function(e){var t=ge.indexOf(e);De(-1===t?""===e?{elist:[e]}:{elist:[].concat(o(ge),[e])}:""===e?{elist:[]}:{elist:ge.filter((function(t){return t!==e}))})},label:h("Select Episodes to be displayed","podcast-player")}),!!Le.length&&"link"!==O&&!!ge.filter(Boolean).length&&wp.element.createElement(k,{label:h("Show or Hide above selected episodes","podcast-player"),value:Ee,onChange:function(e){return De({edisplay:e})},options:[{value:"",label:h("Show above selected episodes","podcast-player")},{value:"hide",label:h("Hide above selected episodes","podcast-player")}]})),!!this.isPremium&&wp.element.createElement(x,{initialOpen:!1,title:h("Custom Audio Message","podcast-player")},wp.element.createElement(D,{label:h("Enter URL of mp3 audio file to be played","podcast-player"),value:ie,onChange:function(e){return De({audioMsg:e})}}),wp.element.createElement(_,{label:h("Replay Frequency","podcast-player"),help:h("After how many episodes the audio should be replayed","podcast-player"),value:se,onChange:function(e){return De({playFreq:e})},min:0,max:100}),wp.element.createElement(k,{label:h("When to start playing the audio message","podcast-player"),value:ce,onChange:function(e){return De({msgStart:e})},options:[{value:"start",label:h("Start of the Episode","podcast-player")},{value:"end",label:h("End of the Episode","podcast-player")},{value:"custom",label:h("Custom Time","podcast-player")}]}),ce&&"custom"===ce&&wp.element.createElement("div",{className:"components-base-control"},wp.element.createElement("label",{className:"components-base-control__label"},h("Start playing audio at (time in hh:mm:ss)")),wp.element.createElement("div",{className:"components-datetime__time-field components-datetime__time-field-time"},wp.element.createElement("input",{className:"components-datetime__time-field-hours-input",type:"number",step:1,min:0,max:10,value:pe[0],onChange:function(e){var t=e.target.value,a=pe[1]?pe[1]:0,n=pe[2]?pe[2]:0;De({msgTime:[t,a,n]})}}),wp.element.createElement("span",{className:"components-datetime__time-separator","aria-hidden":"true"},":"),wp.element.createElement("input",{className:"components-datetime__time-field-hours-input",type:"number",step:1,min:0,max:59,value:pe[1],onChange:function(e){var t=e.target.value,a=pe[0]?pe[0]:0,n=pe[2]?pe[2]:0;De({msgTime:[a,t,n]})}}),wp.element.createElement("span",{className:"components-datetime__time-separator","aria-hidden":"true"},":"),wp.element.createElement("input",{className:"components-datetime__time-field-hours-input",type:"number",step:1,min:0,max:59,value:pe[2],onChange:function(e){var t=e.target.value,a=pe[0]?pe[0]:0,n=pe[1]?pe[1]:0;De({msgTime:[a,n,t]})}}))),wp.element.createElement(D,{label:h("Message to be displayed while playing audio.","podcast-player"),value:ue,onChange:function(e){return De({msgText:e})}}))),wp.element.createElement(P,null,wp.element.createElement(U,{block:"podcast-player/podcast-player",attributes:this.props.attributes})))}}])&&c(a.prototype,l),g}(y),I=wp.i18n.__;(0,wp.blocks.registerBlockType)("podcast-player/podcast-player",{title:I("Podcast Player","podcast-player"),description:I("Host your podcast anywhere, display them only using podcasting feed url.","podcast-player"),icon:wp.element.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",width:"32",height:"32",viewBox:"0 0 32 32"},wp.element.createElement("path",{d:"M32 16c0-8.837-7.163-16-16-16s-16 7.163-16 16c0 6.877 4.339 12.739 10.428 15.002l-0.428 0.998h12l-0.428-0.998c6.089-2.263 10.428-8.125 10.428-15.002zM15.212 19.838c-0.713-0.306-1.212-1.014-1.212-1.838 0-1.105 0.895-2 2-2s2 0.895 2 2c0 0.825-0.499 1.533-1.212 1.839l-0.788-1.839-0.788 1.838zM16.821 19.915c1.815-0.379 3.179-1.988 3.179-3.915 0-2.209-1.791-4-4-4s-4 1.791-4 4c0 1.928 1.364 3.535 3.18 3.913l-2.332 5.441c-2.851-1.223-4.848-4.056-4.848-7.355 0-4.418 3.582-8.375 8-8.375s8 3.957 8 8.375c0 3.299-1.997 6.131-4.848 7.355l-2.331-5.439zM21.514 30.866l-2.31-5.39c3.951-1.336 6.796-5.073 6.796-9.476 0-5.523-4.477-10-10-10s-10 4.477-10 10c0 4.402 2.845 8.14 6.796 9.476l-2.31 5.39c-4.987-2.14-8.481-7.095-8.481-12.866 0-7.729 6.266-14.37 13.995-14.37s13.995 6.641 13.995 14.37c0 5.771-3.494 10.726-8.481 12.866z"})),category:"widgets",keywords:[I("Podcast","featured-content"),I("Feed to Audio","featured-content"),I("Podcasting","featured-content")],edit:N,save:function(){return null}})}();