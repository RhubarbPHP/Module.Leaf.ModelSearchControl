rhubarb.vb.create('ModelSearchControlExampleViewBridge', function(){
   return {
       attachEvents: function(){
           this.findChildViewBridge('contactID').attachClientEventHandler('ValueChanged',function(control){
               var item = control.getSelectedItem();

               alert(item.data.firstname + ' is ' + item.data.age + ' years old!');
           })
       }
   }
});