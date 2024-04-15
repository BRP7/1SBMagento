varienGrid.prototype.doFilter=function(){     
            var filters = $$('#'+this.containerId+' .filter input', '#'+this.containerId+' .filter select');
            var elements = [];
            filters.push(customtextbox);
            for(var i in filters){
                if(filters[i].value && filters[i].value.length) elements.push(filters[i]);
            }
            console.log(elements);
            // debugger;
            if (!this.doFilterCallback || (this.doFilterCallback && this.doFilterCallback())) {
                this.reload(this.addVarToUrl(this.filterVar, encode_base64(Form.serializeElements(elements))));
            }
        };
 

   // banner1.js

// Extend the varienGrid class
// var Banner1Grid = Class.create(varienGrid, {
//     // Override the doFilter method
//     doFilter: function() {
//         console.log(22)
//                     var filters = $$('#'+this.containerId+' .filter input', '#'+this.containerId+' .filter select');
//                     var elements = [];
//                     for(var i in filters){
//                         if(filters[i].value && filters[i].value.length) elements.push(filters[i]);
//                         // console.log(filters[i]);
//                         elements.push(text-box-id);
            
//                     }
//                     // elements.push(text-box-id);
//                     console.log(elements);  
//                     // debugger;
//                     if (!this.doFilterCallback || (this.doFilterCallback && this.doFilterCallback())) {
//                         this.reload(this.addVarToUrl(this.filterVar, encode_base64(Form.serializeElements(elements))));
//                     }
//                     console.log("Custom doFilter method in Banner1Grid");
//                     // exit;
//                 },
//                 // filterKeyPress : function(event){
//                 //     if(event.keyCode==Event.KEY_RETURN){
//                 //         Banner1Grid.doFilter();
//                 //     }
//                 // }
// });


