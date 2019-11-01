!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t(require("jquery")):"function"==typeof define&&define.amd?define("upload",["jquery"],t):(e=e||self).upload=t(e.jQuery)}(this,function(r){"use strict";function g(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function n(e,t){for(var r=0;r<t.length;r++){var n=t[r];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function b(e,t,r){return t&&n(e.prototype,t),r&&n(e,r),e}r=r&&r.hasOwnProperty("default")?r.default:r;var e;"undefined"!=typeof globalThis?globalThis:"undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self&&self;return function(e,t){e.exports=function(u){function e(e,t){return t={exports:{}},e(t,t.exports),t.exports}u=u&&u.hasOwnProperty("default")?u["default"]:u;var o=e(function(t){(function(){var e=function n(e){if(!(this instanceof n)){return new n(e)}this.version=1;this.support=typeof File!=="undefined"&&typeof Blob!=="undefined"&&typeof FileList!=="undefined"&&(!!Blob.prototype.webkitSlice||!!Blob.prototype.mozSlice||!!Blob.prototype.slice||false);if(!this.support)return false;var d=this;d.files=[];d.defaults={chunkSize:1*1024*1024,forceChunkSize:false,simultaneousUploads:3,fileParameterName:"file",chunkNumberParameterName:"resumableChunkNumber",chunkSizeParameterName:"resumableChunkSize",currentChunkSizeParameterName:"resumableCurrentChunkSize",totalSizeParameterName:"resumableTotalSize",typeParameterName:"resumableType",identifierParameterName:"resumableIdentifier",fileNameParameterName:"resumableFilename",relativePathParameterName:"resumableRelativePath",totalChunksParameterName:"resumableTotalChunks",throttleProgressCallbacks:.5,query:{},headers:{},preprocess:null,method:"multipart",uploadMethod:"POST",testMethod:"GET",prioritizeFirstAndLastChunk:false,target:"/",testTarget:null,parameterNamespace:"",testChunks:true,generateUniqueIdentifier:null,getTarget:null,maxChunkRetries:100,chunkRetryInterval:undefined,permanentErrors:[400,404,415,500,501],maxFiles:undefined,withCredentials:false,xhrTimeout:0,clearInput:true,chunkFormat:"blob",setChunkTypeFromFile:false,maxFilesErrorCallback:function e(t,r){var n=d.getOpt("maxFiles");alert("Please upload no more than "+n+" file"+(n===1?"":"s")+" at a time.")},minFileSize:1,minFileSizeErrorCallback:function e(t,r){alert(t.fileName||t.name+" is too small, please upload files larger than "+h.formatSize(d.getOpt("minFileSize"))+".")},maxFileSize:undefined,maxFileSizeErrorCallback:function e(t,r){alert(t.fileName||t.name+" is too large, please upload files less than "+h.formatSize(d.getOpt("maxFileSize"))+".")},fileType:[],fileTypeErrorCallback:function e(t,r){alert(t.fileName||t.name+" has type not allowed, please upload files of type "+d.getOpt("fileType")+".")}};d.opts=e||{};d.getOpt=function(e){var t=this;if(e instanceof Array){var r={};h.each(e,function(e){r[e]=t.getOpt(e)});return r}if(t instanceof f){if(typeof t.opts[e]!=="undefined"){return t.opts[e]}else{t=t.fileObj}}if(t instanceof m){if(typeof t.opts[e]!=="undefined"){return t.opts[e]}else{t=t.resumableObj}}if(t instanceof n){if(typeof t.opts[e]!=="undefined"){return t.opts[e]}else{return t.defaults[e]}}};d.events=[];d.on=function(e,t){d.events.push(e.toLowerCase(),t)};d.fire=function(){var e=[];for(var t=0;t<arguments.length;t++){e.push(arguments[t])}var r=e[0].toLowerCase();for(var t=0;t<=d.events.length;t+=2){if(d.events[t]==r)d.events[t+1].apply(d,e.slice(1));if(d.events[t]=="catchall")d.events[t+1].apply(null,e)}if(r=="fileerror")d.fire("error",e[2],e[1]);if(r=="fileprogress")d.fire("progress")};var h={stopEvent:function e(t){t.stopPropagation();t.preventDefault()},each:function e(t,r){if(typeof t.length!=="undefined"){for(var n=0;n<t.length;n++){if(r(t[n])===false)return}}else{for(n in t){if(r(n,t[n])===false)return}}},generateUniqueIdentifier:function e(t,r){var n=d.getOpt("generateUniqueIdentifier");if(typeof n==="function"){return n(t,r)}var i=t.webkitRelativePath||t.fileName||t.name;var a=t.size;return a+"-"+i.replace(/[^0-9a-zA-Z_-]/gim,"")},contains:function e(t,r){var n=false;h.each(t,function(e){if(e==r){n=true;return false}return true});return n},formatSize:function e(t){if(t<1024){return t+" bytes"}else if(t<1024*1024){return(t/1024).toFixed(0)+" KB"}else if(t<1024*1024*1024){return(t/1024/1024).toFixed(1)+" MB"}else{return(t/1024/1024/1024).toFixed(1)+" GB"}},getTarget:function e(t,r){var n=d.getOpt("target");if(t==="test"&&d.getOpt("testTarget")){n=d.getOpt("testTarget")==="/"?d.getOpt("target"):d.getOpt("testTarget")}if(typeof n==="function"){return n(r)}var i=n.indexOf("?")<0?"?":"&";var a=r.join("&");return n+i+a}};var t=function e(t){h.stopEvent(t);if(t.dataTransfer&&t.dataTransfer.items){i(t.dataTransfer.items,t)}else if(t.dataTransfer&&t.dataTransfer.files){i(t.dataTransfer.files,t)}};var r=function e(t){t.preventDefault()};function a(e,t,r,n){var i;if(e.isFile){return e.file(function(e){e.relativePath=t+e.name;r.push(e);n()})}else if(e.isDirectory){i=e}else if(e instanceof File){r.push(e)}if("function"===typeof e.webkitGetAsEntry){i=e.webkitGetAsEntry()}if(i&&i.isDirectory){return o(i,t+i.name+"/",r,n)}if("function"===typeof e.getAsFile){e=e.getAsFile();if(e instanceof File){e.relativePath=t+e.name;r.push(e)}}n()}function s(e,t){if(!e||e.length===0){return t()}e[0](function(){s(e.slice(1),t)})}function o(e,t,r,n){var i=e.createReader();i.readEntries(function(e){if(!e.length){return n()}s(e.map(function(e){return a.bind(null,e,t,r)}),n)})}function i(e,t){if(!e.length){return}d.fire("beforeAdd");var r=[];s(Array.prototype.map.call(e,function(e){return a.bind(null,e,"",r)}),function(){if(r.length){u(r,t)}})}var u=function e(t,o){var u=0;var f=d.getOpt(["maxFiles","minFileSize","maxFileSize","maxFilesErrorCallback","minFileSizeErrorCallback","maxFileSizeErrorCallback","fileType","fileTypeErrorCallback"]);if(typeof f.maxFiles!=="undefined"&&f.maxFiles<t.length+d.files.length){if(f.maxFiles===1&&d.files.length===1&&t.length===1){d.removeFile(d.files[0])}else{f.maxFilesErrorCallback(t,u++);return false}}var l=[],c=[],r=t.length;var p=function e(){if(!--r){if(!l.length&&!c.length){return}window.setTimeout(function(){d.fire("filesAdded",l,c)},0)}};h.each(t,function(r){var e=r.name;if(f.fileType.length>0){var t=false;for(var n in f.fileType){var i="."+f.fileType[n];if(e.toLowerCase().indexOf(i.toLowerCase(),e.length-i.length)!==-1){t=true;break}}if(!t){f.fileTypeErrorCallback(r,u++);return false}}if(typeof f.minFileSize!=="undefined"&&r.size<f.minFileSize){f.minFileSizeErrorCallback(r,u++);return false}if(typeof f.maxFileSize!=="undefined"&&r.size>f.maxFileSize){f.maxFileSizeErrorCallback(r,u++);return false}function a(t){if(!d.getFromUniqueIdentifier(t)){(function(){r.uniqueIdentifier=t;var e=new m(d,r,t);d.files.push(e);l.push(e);e.container=typeof o!="undefined"?o.srcElement:null;window.setTimeout(function(){d.fire("fileAdded",e,o)},0)})()}else{c.push(r)}p()}var s=h.generateUniqueIdentifier(r,o);if(s&&typeof s.then==="function"){s.then(function(e){a(e)},function(){p()})}else{a(s)}})};function m(e,t,r){var n=this;n.opts={};n.getOpt=e.getOpt;n._prevProgress=0;n.resumableObj=e;n.file=t;n.fileName=t.fileName||t.name;n.size=t.size;n.relativePath=t.relativePath||t.webkitRelativePath||n.fileName;n.uniqueIdentifier=r;n._pause=false;n.container="";var i=r!==undefined;var a=function e(t,r){switch(t){case"progress":n.resumableObj.fire("fileProgress",n,r);break;case"error":n.abort();i=true;n.chunks=[];n.resumableObj.fire("fileError",n,r);break;case"success":if(i)return;n.resumableObj.fire("fileProgress",n);if(n.isComplete()){n.resumableObj.fire("fileSuccess",n,r)}break;case"retry":n.resumableObj.fire("fileRetry",n);break}};n.chunks=[];n.abort=function(){var t=0;h.each(n.chunks,function(e){if(e.status()=="uploading"){e.abort();t++}});if(t>0)n.resumableObj.fire("fileProgress",n)};n.cancel=function(){var e=n.chunks;n.chunks=[];h.each(e,function(e){if(e.status()=="uploading"){e.abort();n.resumableObj.uploadNextChunk()}});n.resumableObj.removeFile(n);n.resumableObj.fire("fileProgress",n)};n.retry=function(){n.bootstrap();var e=false;n.resumableObj.on("chunkingComplete",function(){if(!e)n.resumableObj.upload();e=true})};n.bootstrap=function(){n.abort();i=false;n.chunks=[];n._prevProgress=0;var e=n.getOpt("forceChunkSize")?Math.ceil:Math.floor;var t=Math.max(e(n.file.size/n.getOpt("chunkSize")),1);for(var r=0;r<t;r++){(function(e){window.setTimeout(function(){n.chunks.push(new f(n.resumableObj,n,e,a));n.resumableObj.fire("chunkingProgress",n,e/t)},0)})(r)}window.setTimeout(function(){n.resumableObj.fire("chunkingComplete",n)},0)};n.progress=function(){if(i)return 1;var t=0;var r=false;h.each(n.chunks,function(e){if(e.status()=="error")r=true;t+=e.progress(true)});t=r?1:t>.99999?1:t;t=Math.max(n._prevProgress,t);n._prevProgress=t;return t};n.isUploading=function(){var t=false;h.each(n.chunks,function(e){if(e.status()=="uploading"){t=true;return false}});return t};n.isComplete=function(){var r=false;h.each(n.chunks,function(e){var t=e.status();if(t=="pending"||t=="uploading"||e.preprocessState===1){r=true;return false}});return!r};n.pause=function(e){if(typeof e==="undefined"){n._pause=n._pause?false:true}else{n._pause=e}};n.isPaused=function(){return n._pause};n.resumableObj.fire("chunkingStart",n);n.bootstrap();return this}function f(e,t,r,n){var d=this;d.opts={};d.getOpt=e.getOpt;d.resumableObj=e;d.fileObj=t;d.fileObjSize=t.size;d.fileObjType=t.file.type;d.offset=r;d.callback=n;d.lastProgressCallback=new Date;d.tested=false;d.retries=0;d.pendingRetry=false;d.preprocessState=0;var i=d.getOpt("chunkSize");d.loaded=0;d.startByte=d.offset*i;d.endByte=Math.min(d.fileObjSize,(d.offset+1)*i);if(d.fileObjSize-d.endByte<i&&!d.getOpt("forceChunkSize")){d.endByte=d.fileObjSize}d.xhr=null;d.test=function(){d.xhr=new XMLHttpRequest;var e=function e(t){d.tested=true;var r=d.status();if(r=="success"){d.callback(r,d.message());d.resumableObj.uploadNextChunk()}else{d.send()}};d.xhr.addEventListener("load",e,false);d.xhr.addEventListener("error",e,false);d.xhr.addEventListener("timeout",e,false);var r=[];var n=d.getOpt("parameterNamespace");var t=d.getOpt("query");if(typeof t=="function")t=t(d.fileObj,d);h.each(t,function(e,t){r.push([encodeURIComponent(n+e),encodeURIComponent(t)].join("="))});r=r.concat([["chunkNumberParameterName",d.offset+1],["chunkSizeParameterName",d.getOpt("chunkSize")],["currentChunkSizeParameterName",d.endByte-d.startByte],["totalSizeParameterName",d.fileObjSize],["typeParameterName",d.fileObjType],["identifierParameterName",d.fileObj.uniqueIdentifier],["fileNameParameterName",d.fileObj.fileName],["relativePathParameterName",d.fileObj.relativePath],["totalChunksParameterName",d.fileObj.chunks.length]].filter(function(e){return d.getOpt(e[0])}).map(function(e){return[n+d.getOpt(e[0]),encodeURIComponent(e[1])].join("=")}));d.xhr.open(d.getOpt("testMethod"),h.getTarget("test",r));d.xhr.timeout=d.getOpt("xhrTimeout");d.xhr.withCredentials=d.getOpt("withCredentials");var i=d.getOpt("headers");if(typeof i==="function"){i=i(d.fileObj,d)}h.each(i,function(e,t){d.xhr.setRequestHeader(e,t)});d.xhr.send(null)};d.preprocessFinished=function(){d.preprocessState=2;d.send()};d.send=function(){var e=d.getOpt("preprocess");if(typeof e==="function"){switch(d.preprocessState){case 0:d.preprocessState=1;e(d);return;case 1:return}}if(d.getOpt("testChunks")&&!d.tested){d.test();return}d.xhr=new XMLHttpRequest;d.xhr.upload.addEventListener("progress",function(e){if(new Date-d.lastProgressCallback>d.getOpt("throttleProgressCallbacks")*1e3){d.callback("progress");d.lastProgressCallback=new Date}d.loaded=e.loaded||0},false);d.loaded=0;d.pendingRetry=false;d.callback("progress");var t=function e(t){var r=d.status();if(r=="success"||r=="error"){d.callback(r,d.message());d.resumableObj.uploadNextChunk()}else{d.callback("retry",d.message());d.abort();d.retries++;var n=d.getOpt("chunkRetryInterval");if(n!==undefined){d.pendingRetry=true;setTimeout(d.send,n)}else{d.send()}}};d.xhr.addEventListener("load",t,false);d.xhr.addEventListener("error",t,false);d.xhr.addEventListener("timeout",t,false);var r=[["chunkNumberParameterName",d.offset+1],["chunkSizeParameterName",d.getOpt("chunkSize")],["currentChunkSizeParameterName",d.endByte-d.startByte],["totalSizeParameterName",d.fileObjSize],["typeParameterName",d.fileObjType],["identifierParameterName",d.fileObj.uniqueIdentifier],["fileNameParameterName",d.fileObj.fileName],["relativePathParameterName",d.fileObj.relativePath],["totalChunksParameterName",d.fileObj.chunks.length]].filter(function(e){return d.getOpt(e[0])}).reduce(function(e,t){e[d.getOpt(t[0])]=t[1];return e},{});var n=d.getOpt("query");if(typeof n=="function")n=n(d.fileObj,d);h.each(n,function(e,t){r[e]=t});var i=d.fileObj.file.slice?"slice":d.fileObj.file.mozSlice?"mozSlice":d.fileObj.file.webkitSlice?"webkitSlice":"slice";var a=d.fileObj.file[i](d.startByte,d.endByte,d.getOpt("setChunkTypeFromFile")?d.fileObj.file.type:"");var s=null;var o=[];var u=d.getOpt("parameterNamespace");if(d.getOpt("method")==="octet"){s=a;h.each(r,function(e,t){o.push([encodeURIComponent(u+e),encodeURIComponent(t)].join("="))})}else{s=new FormData;h.each(r,function(e,t){s.append(u+e,t);o.push([encodeURIComponent(u+e),encodeURIComponent(t)].join("="))});if(d.getOpt("chunkFormat")=="blob"){s.append(u+d.getOpt("fileParameterName"),a,d.fileObj.fileName)}else if(d.getOpt("chunkFormat")=="base64"){var f=new FileReader;f.onload=function(e){s.append(u+d.getOpt("fileParameterName"),f.result);d.xhr.send(s)};f.readAsDataURL(a)}}var l=h.getTarget("upload",o);var c=d.getOpt("uploadMethod");d.xhr.open(c,l);if(d.getOpt("method")==="octet"){d.xhr.setRequestHeader("Content-Type","application/octet-stream")}d.xhr.timeout=d.getOpt("xhrTimeout");d.xhr.withCredentials=d.getOpt("withCredentials");var p=d.getOpt("headers");if(typeof p==="function"){p=p(d.fileObj,d)}h.each(p,function(e,t){d.xhr.setRequestHeader(e,t)});if(d.getOpt("chunkFormat")=="blob"){d.xhr.send(s)}};d.abort=function(){if(d.xhr)d.xhr.abort();d.xhr=null};d.status=function(){if(d.pendingRetry){return"uploading"}else if(!d.xhr){return"pending"}else if(d.xhr.readyState<4){return"uploading"}else{if(d.xhr.status==200||d.xhr.status==201){return"success"}else if(h.contains(d.getOpt("permanentErrors"),d.xhr.status)||d.retries>=d.getOpt("maxChunkRetries")){return"error"}else{d.abort();return"pending"}}};d.message=function(){return d.xhr?d.xhr.responseText:""};d.progress=function(e){if(typeof e==="undefined")e=false;var t=e?(d.endByte-d.startByte)/d.fileObjSize:1;if(d.pendingRetry)return 0;if(!d.xhr||!d.xhr.status)t*=.95;var r=d.status();switch(r){case"success":case"error":return 1*t;case"pending":return 0*t;default:return d.loaded/(d.endByte-d.startByte)*t}};return this}d.uploadNextChunk=function(){var t=false;if(d.getOpt("prioritizeFirstAndLastChunk")){h.each(d.files,function(e){if(e.chunks.length&&e.chunks[0].status()=="pending"&&e.chunks[0].preprocessState===0){e.chunks[0].send();t=true;return false}if(e.chunks.length>1&&e.chunks[e.chunks.length-1].status()=="pending"&&e.chunks[e.chunks.length-1].preprocessState===0){e.chunks[e.chunks.length-1].send();t=true;return false}});if(t)return true}h.each(d.files,function(e){if(e.isPaused()===false){h.each(e.chunks,function(e){if(e.status()=="pending"&&e.preprocessState===0){e.send();t=true;return false}})}if(t)return false});if(t)return true;var r=false;h.each(d.files,function(e){if(!e.isComplete()){r=true;return false}});if(!r){d.fire("complete")}return false};d.assignBrowse=function(e,i){if(typeof e.length=="undefined")e=[e];h.each(e,function(e){var t;if(e.tagName==="INPUT"&&e.type==="file"){t=e}else{t=document.createElement("input");t.setAttribute("type","file");t.style.display="none";e.addEventListener("click",function(){t.style.opacity=0;t.style.display="block";t.focus();t.click();t.style.display="none"},false);e.appendChild(t)}var r=d.getOpt("maxFiles");if(typeof r==="undefined"||r!=1){t.setAttribute("multiple","multiple")}else{t.removeAttribute("multiple")}if(i){t.setAttribute("webkitdirectory","webkitdirectory")}else{t.removeAttribute("webkitdirectory")}var n=d.getOpt("fileType");if(typeof n!=="undefined"&&n.length>=1){t.setAttribute("accept",n.map(function(e){return"."+e}).join(","))}else{t.removeAttribute("accept")}t.addEventListener("change",function(e){u(e.target.files,e);var t=d.getOpt("clearInput");if(t){e.target.value=""}},false)})};d.assignDrop=function(e){if(typeof e.length=="undefined")e=[e];h.each(e,function(e){e.addEventListener("dragover",r,false);e.addEventListener("dragenter",r,false);e.addEventListener("drop",t,false)})};d.unAssignDrop=function(e){if(typeof e.length=="undefined")e=[e];h.each(e,function(e){e.removeEventListener("dragover",r);e.removeEventListener("dragenter",r);e.removeEventListener("drop",t)})};d.isUploading=function(){var t=false;h.each(d.files,function(e){if(e.isUploading()){t=true;return false}});return t};d.upload=function(){if(d.isUploading())return;d.fire("uploadStart");for(var e=1;e<=d.getOpt("simultaneousUploads");e++){d.uploadNextChunk()}};d.pause=function(){h.each(d.files,function(e){e.abort()});d.fire("pause")};d.cancel=function(){d.fire("beforeCancel");for(var e=d.files.length-1;e>=0;e--){d.files[e].cancel()}d.fire("cancel")};d.progress=function(){var t=0;var r=0;h.each(d.files,function(e){t+=e.progress()*e.size;r+=e.size});return r>0?t/r:0};d.addFile=function(e,t){u([e],t)};d.addFiles=function(e,t){u(e,t)};d.removeFile=function(e){for(var t=d.files.length-1;t>=0;t--){if(d.files[t]===e){d.files.splice(t,1)}}};d.getFromUniqueIdentifier=function(t){var r=false;h.each(d.files,function(e){if(e.uniqueIdentifier==t)r=e});return r};d.getSize=function(){var t=0;h.each(d.files,function(e){t+=e.size});return t};d.handleDropEvent=function(e){t(e)};d.handleChangeEvent=function(e){u(e.target.files,e);e.target.value=""};d.updateQuery=function(e){d.opts.query=e};return this};{t.exports=e}})()}),p=e(function(t,e){(function(e){{t.exports=e()}})(function(l){var s=function e(t,r){return t+r&4294967295},n=["0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"];function o(e,t,r,n,i,a){t=s(s(t,e),s(n,a));return s(t<<i|t>>>32-i,r)}function u(e,t,r,n,i,a,s){return o(t&r|~t&n,e,t,i,a,s)}function f(e,t,r,n,i,a,s){return o(t&n|r&~n,e,t,i,a,s)}function c(e,t,r,n,i,a,s){return o(t^r^n,e,t,i,a,s)}function p(e,t,r,n,i,a,s){return o(r^(t|~n),e,t,i,a,s)}function d(e,t){var r=e[0],n=e[1],i=e[2],a=e[3];r=u(r,n,i,a,t[0],7,-680876936);a=u(a,r,n,i,t[1],12,-389564586);i=u(i,a,r,n,t[2],17,606105819);n=u(n,i,a,r,t[3],22,-1044525330);r=u(r,n,i,a,t[4],7,-176418897);a=u(a,r,n,i,t[5],12,1200080426);i=u(i,a,r,n,t[6],17,-1473231341);n=u(n,i,a,r,t[7],22,-45705983);r=u(r,n,i,a,t[8],7,1770035416);a=u(a,r,n,i,t[9],12,-1958414417);i=u(i,a,r,n,t[10],17,-42063);n=u(n,i,a,r,t[11],22,-1990404162);r=u(r,n,i,a,t[12],7,1804603682);a=u(a,r,n,i,t[13],12,-40341101);i=u(i,a,r,n,t[14],17,-1502002290);n=u(n,i,a,r,t[15],22,1236535329);r=f(r,n,i,a,t[1],5,-165796510);a=f(a,r,n,i,t[6],9,-1069501632);i=f(i,a,r,n,t[11],14,643717713);n=f(n,i,a,r,t[0],20,-373897302);r=f(r,n,i,a,t[5],5,-701558691);a=f(a,r,n,i,t[10],9,38016083);i=f(i,a,r,n,t[15],14,-660478335);n=f(n,i,a,r,t[4],20,-405537848);r=f(r,n,i,a,t[9],5,568446438);a=f(a,r,n,i,t[14],9,-1019803690);i=f(i,a,r,n,t[3],14,-187363961);n=f(n,i,a,r,t[8],20,1163531501);r=f(r,n,i,a,t[13],5,-1444681467);a=f(a,r,n,i,t[2],9,-51403784);i=f(i,a,r,n,t[7],14,1735328473);n=f(n,i,a,r,t[12],20,-1926607734);r=c(r,n,i,a,t[5],4,-378558);a=c(a,r,n,i,t[8],11,-2022574463);i=c(i,a,r,n,t[11],16,1839030562);n=c(n,i,a,r,t[14],23,-35309556);r=c(r,n,i,a,t[1],4,-1530992060);a=c(a,r,n,i,t[4],11,1272893353);i=c(i,a,r,n,t[7],16,-155497632);n=c(n,i,a,r,t[10],23,-1094730640);r=c(r,n,i,a,t[13],4,681279174);a=c(a,r,n,i,t[0],11,-358537222);i=c(i,a,r,n,t[3],16,-722521979);n=c(n,i,a,r,t[6],23,76029189);r=c(r,n,i,a,t[9],4,-640364487);a=c(a,r,n,i,t[12],11,-421815835);i=c(i,a,r,n,t[15],16,530742520);n=c(n,i,a,r,t[2],23,-995338651);r=p(r,n,i,a,t[0],6,-198630844);a=p(a,r,n,i,t[7],10,1126891415);i=p(i,a,r,n,t[14],15,-1416354905);n=p(n,i,a,r,t[5],21,-57434055);r=p(r,n,i,a,t[12],6,1700485571);a=p(a,r,n,i,t[3],10,-1894986606);i=p(i,a,r,n,t[10],15,-1051523);n=p(n,i,a,r,t[1],21,-2054922799);r=p(r,n,i,a,t[8],6,1873313359);a=p(a,r,n,i,t[15],10,-30611744);i=p(i,a,r,n,t[6],15,-1560198380);n=p(n,i,a,r,t[13],21,1309151649);r=p(r,n,i,a,t[4],6,-145523070);a=p(a,r,n,i,t[11],10,-1120210379);i=p(i,a,r,n,t[2],15,718787259);n=p(n,i,a,r,t[9],21,-343485551);e[0]=s(r,e[0]);e[1]=s(n,e[1]);e[2]=s(i,e[2]);e[3]=s(a,e[3])}function h(e){var t=[],r;for(r=0;r<64;r+=4){t[r>>2]=e.charCodeAt(r)+(e.charCodeAt(r+1)<<8)+(e.charCodeAt(r+2)<<16)+(e.charCodeAt(r+3)<<24)}return t}function m(e){var t=[],r;for(r=0;r<64;r+=4){t[r>>2]=e[r]+(e[r+1]<<8)+(e[r+2]<<16)+(e[r+3]<<24)}return t}function i(e){var t=e.length,r=[1732584193,-271733879,-1732584194,271733878],n,i,a,s,o,u;for(n=64;n<=t;n+=64){d(r,h(e.substring(n-64,n)))}e=e.substring(n-64);i=e.length;a=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];for(n=0;n<i;n+=1){a[n>>2]|=e.charCodeAt(n)<<(n%4<<3)}a[n>>2]|=128<<(n%4<<3);if(n>55){d(r,a);for(n=0;n<16;n+=1){a[n]=0}}s=t*8;s=s.toString(16).match(/(.*?)(.{0,8})$/);o=parseInt(s[2],16);u=parseInt(s[1],16)||0;a[14]=o;a[15]=u;d(r,a);return r}function a(e){var t=e.length,r=[1732584193,-271733879,-1732584194,271733878],n,i,a,s,o,u;for(n=64;n<=t;n+=64){d(r,m(e.subarray(n-64,n)))}e=n-64<t?e.subarray(n-64):new Uint8Array(0);i=e.length;a=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];for(n=0;n<i;n+=1){a[n>>2]|=e[n]<<(n%4<<3)}a[n>>2]|=128<<(n%4<<3);if(n>55){d(r,a);for(n=0;n<16;n+=1){a[n]=0}}s=t*8;s=s.toString(16).match(/(.*?)(.{0,8})$/);o=parseInt(s[2],16);u=parseInt(s[1],16)||0;a[14]=o;a[15]=u;d(r,a);return r}function r(e){var t="",r;for(r=0;r<4;r+=1){t+=n[e>>r*8+4&15]+n[e>>r*8&15]}return t}function g(e){var t;for(t=0;t<e.length;t+=1){e[t]=r(e[t])}return e.join("")}if(g(i("hello"))!=="5d41402abc4b2a76b9719d911017c592"){s=function e(t,r){var n=(t&65535)+(r&65535),i=(t>>16)+(r>>16)+(n>>16);return i<<16|n&65535}}if(typeof ArrayBuffer!=="undefined"&&!ArrayBuffer.prototype.slice){(function(){function f(e,t){e=e|0||0;if(e<0){return Math.max(e+t,0)}return Math.min(e,t)}ArrayBuffer.prototype.slice=function(e,t){var r=this.byteLength,n=f(e,r),i=r,a,s,o,u;if(t!==l){i=f(t,r)}if(n>i){return new ArrayBuffer(0)}a=i-n;s=new ArrayBuffer(a);o=new Uint8Array(s);u=new Uint8Array(this,n,a);o.set(u);return s}})()}function b(e){if(/[\u0080-\uFFFF]/.test(e)){e=unescape(encodeURIComponent(e))}return e}function t(e,t){var r=e.length,n=new ArrayBuffer(r),i=new Uint8Array(n),a;for(a=0;a<r;a+=1){i[a]=e.charCodeAt(a)}return t?i:n}function v(e){return String.fromCharCode.apply(null,new Uint8Array(e))}function y(e,t,r){var n=new Uint8Array(e.byteLength+t.byteLength);n.set(new Uint8Array(e));n.set(new Uint8Array(t),e.byteLength);return r?n:n.buffer}function k(e){var t=[],r=e.length,n;for(n=0;n<r-1;n+=2){t.push(parseInt(e.substr(n,2),16))}return String.fromCharCode.apply(String,t)}function O(){this.reset()}O.prototype.append=function(e){this.appendBinary(b(e));return this};O.prototype.appendBinary=function(e){this._buff+=e;this._length+=e.length;var t=this._buff.length,r;for(r=64;r<=t;r+=64){d(this._hash,h(this._buff.substring(r-64,r)))}this._buff=this._buff.substring(r-64);return this};O.prototype.end=function(e){var t=this._buff,r=t.length,n,i=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],a;for(n=0;n<r;n+=1){i[n>>2]|=t.charCodeAt(n)<<(n%4<<3)}this._finish(i,r);a=g(this._hash);if(e){a=k(a)}this.reset();return a};O.prototype.reset=function(){this._buff="";this._length=0;this._hash=[1732584193,-271733879,-1732584194,271733878];return this};O.prototype.getState=function(){return{buff:this._buff,length:this._length,hash:this._hash}};O.prototype.setState=function(e){this._buff=e.buff;this._length=e.length;this._hash=e.hash;return this};O.prototype.destroy=function(){delete this._hash;delete this._buff;delete this._length};O.prototype._finish=function(e,t){var r=t,n,i,a;e[r>>2]|=128<<(r%4<<3);if(r>55){d(this._hash,e);for(r=0;r<16;r+=1){e[r]=0}}n=this._length*8;n=n.toString(16).match(/(.*?)(.{0,8})$/);i=parseInt(n[2],16);a=parseInt(n[1],16)||0;e[14]=i;e[15]=a;d(this._hash,e)};O.hash=function(e,t){return O.hashBinary(b(e),t)};O.hashBinary=function(e,t){var r=i(e),n=g(r);return t?k(n):n};O.ArrayBuffer=function(){this.reset()};O.ArrayBuffer.prototype.append=function(e){var t=y(this._buff.buffer,e,true),r=t.length,n;this._length+=e.byteLength;for(n=64;n<=r;n+=64){d(this._hash,m(t.subarray(n-64,n)))}this._buff=n-64<r?new Uint8Array(t.buffer.slice(n-64)):new Uint8Array(0);return this};O.ArrayBuffer.prototype.end=function(e){var t=this._buff,r=t.length,n=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],i,a;for(i=0;i<r;i+=1){n[i>>2]|=t[i]<<(i%4<<3)}this._finish(n,r);a=g(this._hash);if(e){a=k(a)}this.reset();return a};O.ArrayBuffer.prototype.reset=function(){this._buff=new Uint8Array(0);this._length=0;this._hash=[1732584193,-271733879,-1732584194,271733878];return this};O.ArrayBuffer.prototype.getState=function(){var e=O.prototype.getState.call(this);e.buff=v(e.buff);return e};O.ArrayBuffer.prototype.setState=function(e){e.buff=t(e.buff,true);return O.prototype.setState.call(this,e)};O.ArrayBuffer.prototype.destroy=O.prototype.destroy;O.ArrayBuffer.prototype._finish=O.prototype._finish;O.ArrayBuffer.hash=function(e,t){var r=a(new Uint8Array(e)),n=g(r);return t?k(n):n};return O})}),t,n={},a=".dui-upload-list__item",f="dui-upload-list",r=".dui-progress-bar__inner",i=".dui-progress__text",s=".dui-upload-dragger",l=new(function(){function e(){g(this,e)}b(e,[{key:"md5",value:function e(r,t,n){var i=this;this.aborted=false;this.progress=0;var a=0;var s=File.prototype.slice||File.prototype.mozSlice||File.prototype.webkitSlice;var o=2097152;var u=Math.ceil(r.size/o);var f=new p.ArrayBuffer;var l=new FileReader;c();l.onloadend=function(e){f.append(e.target.result);a++;i.progress=a/u;if(n&&typeof n==="function"){n(i.progress)}if(i.aborted){t("aborted");return}if(a<u){c()}else{t(null,f.end())}};function c(){var e=a*o;var t=e+o>=r.size?r.size:e+o;l.readAsArrayBuffer(s.call(r,e,t))}}},{key:"abort",value:function e(){this.aborted=true}}]);return e}());function c(e){var t=new h(e);return m.call(t)}function d(e,t){var r,n="",i=!1,a=new FileReader;a.onerror=function(e){n="转换错误",i=!0},a.onload=function(e){i=!(n=""),r=e.target.result},a.readAsDataURL(e);var s=setInterval(function(){!0===i&&(clearInterval(s),t(n,r))},10)}function h(e){var t=this,r=t.config=u.extend(true,{el:"",server:"",accept:"images",showFileList:true,listType:"text",fileList:[],autoUpload:true,exts:"",headers:{},pick:"",pickText:"上传图片",name:"file",data:{},testChunks:false,drag:false,onSuccess:"",onError:"",onBefore:"",onComplete:"",onProgress:"",multiple:false,chunkSize:1*1024*1024,maxFiles:undefined,resize:false},n,e);t.render()}function m(){var t=this;return{config:t.config,upload:function e(){t.upload.call(t)},pause:function e(){t.pause.call(t)},cancel:function e(){t.cancel.call(t)}}}return h.prototype.render=function(){var e=this,r=e.config,t=e.el=u(r.el);if(!t[0])throw new Error("upload initialization failed，Because there is no container.");if(!!e.innerHtml&&t.html(e.innerHtml),e.innerHtml=t.html(),e.listItemTpl=function(e,t){return['<li class="dui-upload-list__item is-'+t+'">',"picture"==r.listType?'<img src="'+e.url+'" alt="'+e.name+'" class="dui-upload-list__item-thumbnail">':"",'<a class="dui-upload-list__item-name"><i class="dui-icon-document"></i>'+e.name+"</a>",'<label class="dui-upload-list__item-status-label"><i class="dui-icon-upload-success dui-icon-'+("text"==r.listType?"circle-":"")+'check"></i></label>','<i class="dui-icon-close"></i>',"</li>"].join("")},e.uploadDom=u('<div class="dui-upload dui-upload-'+r.listType+'"></div>'),e.pick=t.find(r.pick)[0]?t.find(r.pick)[0]:t.children()[0]?t.children()[0]:u('<button type="button" class="dui-button dui-button--primary dui-button--small">'+r.pickText+"</button>"),t.prepend(e.uploadDom),e.uploadDom.append(e.pick),r.showFileList){var n=['<ul class="dui-upload-list dui-upload-list--'+r.listType+'"></div>'].join(""),i=e.showListDom=t.find(f)[0]?t.find(f):u(n);if(t.append(i),r.fileList&&0<r.fileList.length){var a=[];u.each(r.fileList,function(e,t){var r=listItemTpl(t,"success");a.push(r)}),i.append(a.join(""))}}var s={target:r.server,query:u.extend(!0,{form:"dui.upload"},r.data),simultaneousUploads:r.simultaneousUploads||3,fileParameterName:r.name,chunkSize:r.chunkSize,headers:r.headers,maxFiles:r.maxFiles,testChunks:r.testChunks};e.r=new o(s),e.setCallBack()},h.prototype.setCallBack=function(){var o=this,i=o.config,n=o.r,e=(o.uploadDom,o.pick),t=o.el.find(s)[0]?o.el.find(s)[0]:o.el[0];n.assignBrowse(e),!1!==i.drag&&n.assignDrop(t),n.on("fileAdded",function(a){var s={name:a.fileName,url:""};i.showFileList&&function(e,t){var r,n="",i=!1,a=new FileReader;a.onerror=function(e){n="转换错误",i=!0},a.onload=function(e){i=!(n=""),r=e.target.result},a.readAsDataURL(e);var s=setInterval(function(){!0===i&&(clearInterval(s),t(n,r))},10)}(a.file,function(e,t){s.url=e?"":t;var r=u(o.listItemTpl(s,"is-ready"));r[0].uploadId=a.uniqueIdentifier,o.showListDom.append(r);var n=['<div class="dui-progress dui-progress--line" style="display:none">','<div class="dui-progress-bar">','<div class="dui-progress-bar__outer" style="height: 2px;">','<div class="dui-progress-bar__inner" style="width: 0%;">',"</div>","</div>","</div>",'<div class="dui-progress__text" style="font-size: 12.8px;">0%</div>',"</div>"].join(""),i=r[0].progress=u(n);r.append(i)}),l.md5(a.file,function(e,t){if(n.opts.query.fileMd5=t,a.file.fileMd5=t,i.autoUpload){var r=!0;i.onBefore&&"function"==typeof i.onBefore&&(r=i.onBefore.call(null,a)),!1!==r&&n.upload()}})}),n.on("fileProgress",function(r){var n=r.progress();i.showFileList&&o.showListDom.find(a).each(function(e,t){t.uploadId==r.uniqueIdentifier&&(t.progress.css("display",""),u(t).find(".dui-progress-bar__inner").css("width",100*n+"%"),u(t).find(".dui-progress__text").text(100*n+"%"))}),i.onProgress&&"function"==typeof i.onProgress&&i.onProgress.call(null,r,n)}),n.on("fileSuccess",function(r,e){i.showFileList&&o.showListDom.find(a).each(function(e,t){t.uploadId==r.uniqueIdentifier&&(u(t).removeClass("is-uploading").addClass("is-success"),t.progress.remove())}),i.onSuccess&&"function"==typeof i.onSuccess&&i.onSuccess.call(null,r,JSON.parse(e))}),n.on("fileError",function(r,e){i.showFileList&&o.showListDom.find(a).each(function(e,t){t.uploadId==r.uniqueIdentifier&&t.remove()}),i.onError&&"function"==typeof i.onError&&i.onError.call(null,r,e)})},h.prototype.upload=function(){this.r.upload()},h.prototype.pause=function(){this.r.pause()},h.prototype.cancel=function(){this.r.cancel()},c.config=function(e){return n=u.extend(!0,n,e),this},c.render=function(e){return c(e)},c}(r)}(e={exports:{}},e.exports),e.exports});