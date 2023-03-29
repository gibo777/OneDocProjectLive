<x-app-layout>


<style type="text/css">
    .button {

background-color: dodgerblue;

border: none;

color: white;

padding: 16px 32px;

text-align: center;

text-decoration: none;

display: inline-block;

font-size: 16px;

margin: 4px 2px;

}

.button:hover {

background-color: lightgreen;

color: grey;
}
</style>


<button class="button">Click me!</button>


        <!-- Dropdown -->       
        <select id='selUser' style='width: 200px;'>
            <option value='0'>-- Select User --</option>          
            <option value='1'>Yogesh singh</option>  
            <option value='2'>Sonarika Bhadoria</option>   
            <option value='3'>Anil Singh</option>        
            <option value='4'>Vishal Sahu</option>        
            <option value='5'>Mayank Patidar</option>        
            <option value='6'>Vijay Mourya</option>        
            <option value='7'>Rakesh sahu</option> 
        </select>   

        <input type='button' value='Seleted option' id='but_read'>

        <br/>
        <div id='result'></div>

        <!-- Script -->
        <script>
        $(document).ready(function(){
            
            // Initialize select2
            $("#selUser").select2();

            // Read selected option
            $('#but_read').click(function(){
                var username = $('#selUser option:selected').text();
                var userid = $('#selUser').val();
           
                $('#result').html("id : " + userid + ", name : " + username);
            });
        });
        </script>
</x-app-layout>