import{LexoRank}from"lexorank";import formPage from"./form";import{tablesome_format}from"./../../table/src/wrapper/date-fns";const Import={process:function(e){this.readAndSendDatafromFile(e)},validateFile:function(e){const t={type:"success",message:"Validation is done, Go ahead to import your data."};if(void 0===e.file)return t.type="fail",t.message="Please attach the file",t;const o=Import._getSupportedFormats();return-1==o.indexOf(e.extension)?(t.type="fail",t.message="Only Supports with "+o.join()+" file formats",t):t},readAndSendDatafromFile:function(e){const t=new FileReader;t.onload=function(t){const o=t.target.result;let n;try{n=XLSX.read(o,{type:"array",cellDates:!0})}catch(t){return formPage.stopSpinner(),formPage.enableSubmitButton(),void alert(t)}let a=n.SheetNames[0],r=n.Sheets[a],s=XLSX.utils.sheet_to_json(r,{defval:"",header:1});const i=Import.getColumns(s,e);Import.createTableRequest({table_title:e.table_title,read_first_row_as_column:e.read_first_row_as_column,columns:i.columns,records:Import.getRows(s,e),last_column_id:i.last_column_id})},t.readAsArrayBuffer(e.file)},createTableRequest:function(e){let t=this;fetch(tablesome_ajax_object.api_endpoints.save_table,{method:"post",headers:{"Content-Type":"application/json","X-WP-Nonce":tablesome_ajax_object.rest_nonce},body:JSON.stringify({table_title:e.table_title,columns:e.columns,last_column_id:e.last_column_id,recordsData:{records_inserted:e.records},origin_location:"import"})}).then((function(e){return e.json()})).then((function(e){return e})).then((function(e){t.saveNotice(e),t.goToTableEditPage(e.table_id)})).catch((function(e){t.errorNotice(e)}))},errorNotice:function(e){let t=jQuery("<span class='save-notice failed'>"+e+"</span>");jQuery(".tablesome__button--wrapper").append(t)},capitalize:function(e){return e.split(" ").map((function(e){return e.charAt(0).toUpperCase()+e.slice(1)})).join(" ")},saveNotice:function(e){let t=jQuery("<span class='save-notice "+e.status+"'>"+this.capitalize(e.status)+" : "+e.message+"</span>");jQuery(".tablesome__button--wrapper").append(t)},goToTableEditPage:function(e){let t=new URL(tablesome_ajax_object.edit_table_url);t.searchParams.set("post",e),window.location.replace(t)},sendRecords:function(e){fetch(tablesome_ajax_object.api_endpoints.import_records,{method:"post",headers:{"Content-Type":"application/json","X-WP-Nonce":tablesome_ajax_object.rest_nonce},body:JSON.stringify(e)}).then((function(t){alert("Table Imported, Successfully.");let o=new URL(tablesome_ajax_object.edit_table_url);o.searchParams.set("post",e.table_id),window.location.replace(o)})).then((function(e){})).catch((function(e){}))},getColumns:function(e,t){let o=e.length>=25?e.slice(0,25):e,n=[],a=1;if(t.read_first_row_as_column)for(let e=0;e<o[0].length;e++)n.push({id:a,name:o[0][e]}),a++;else for(let e=1;e<=o[1].length;e++)n.push({id:a,name:"Column Name "+e}),a++;return n=Import.getFormattedColumns(n,o),{columns:n,last_column_id:a}},getRows:function(e,t){let o=[],n=LexoRank.min().genNext().toString();return e.forEach((function(e,a){let r=t.read_first_row_as_column&&0==a,s=[];e.forEach((function(e,t){let o=e instanceof Date&&!isNaN(e),n=e&&Import.IsFilePath(e),a=e&&Import.isImagePath(e),r=e;if(o){const t=6e4*(new Date).getTimezoneOffset();e=new Date(e.valueOf()-t).valueOf(),r=tablesome_format(e,tablesome_settings.date_format)}a?s.push({html:r,value:e,file_url:e,file_type:"image"}):n?s.push({html:r,value:e,file_url:e,file_type:"other"}):s.push({html:r,value:e})})),r||(o.push({record_id:0,content:Object.values(s),rank_order:n}),n=LexoRank.parse(n).genNext().toString())})),o},_getSupportedFormats:function(){return["xlsx","xlsm","xls","xla","csv"]},_isEmail:function(e){return!!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(e)},isImagePath:function(e){return/\.(jpg|jpeg|png|gif|bmp|svg)$/i.test(e)},IsFilePath:function(e){const t=[".pdf",".doc",".docx",".ppt",".pptx",".pps",".ppsx",".odt",".xls",".xlsx",".csv",".psd",".ai",".eps",".indd",".svg",".jpg",".jpeg",".png",".gif",".bmp",".tif",".tiff",".ico",".txt",".rtf",".odp",".ods",".odg",".odc",".odf",".odb",".odi",".odm",".mp3",".m4a",".ogg",".wav",".mp4",".m4v",".mov",".wmv",".avi",".mpg",".ogv",".3gp",".3g2",".flv",".mkv",".html",".htm",".php"];if("string"!=typeof e)return!1;try{const o=new URL(e).pathname.split(".").pop().toLowerCase();return!!t.includes(`.${o}`)}catch(e){return!1}},_isHTMLContent:function(e){let t=(new DOMParser).parseFromString(e,"text/html");return Array.from(t.body.childNodes).some((e=>1===e.nodeType))},getFormattedColumns:function(e,t){return e.map((function(e,o){let n="text",a={text:0,date:0,number:0,email:0,textarea:0,url:0,file:0};for(let e=0;e<t.length;){t[e].forEach((function(e,t){if(t==o){e instanceof Date&&!isNaN(e)?n="date":"number"==typeof e?n="number":Import._isEmail(e)?n="email":Import._isHTMLContent(e)?n="textarea":Import.IsFilePath(e)?n="file":Import._isUrl(e)&&(n="url");let t=a[n];a[n]=parseInt(t)+1}})),e++}const r=Object.values(a).reduce((function(e,t){return Math.max(e,t)}),0),s=Object.keys(a).find((e=>a[e]===r));return{id:e.id,name:e.name,format:s}}))},_isUrl:function(e){try{new URL(e)}catch(e){return!1}return!0}};export default Import;