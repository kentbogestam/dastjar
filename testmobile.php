<!DOCTYPE html>
<html>
   <head>
      <meta name = "viewport" content = "width = device-width, initial-scale = 1">
      <link rel = "stylesheet" href = "https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
      <script src = "https://code.jquery.com/jquery-1.11.3.min.js"></script>
      <script src = "https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
   </head>

   
      
   <body>
      <div data-role = "page" id = "pageone">
         <div data-role = "header">
            <h1>Header Text</h1>
            <p>
			    <a href="#" data-role="button" data-inline="true">True</a>
			    <a href="#" data-role="button" data-inline="true">False</a>
			</p>
            <form>
			    <label for="textinput-s">Text Input:</label>
			    <input type="text" name="textinput-s" id="textinput-s" placeholder="Text input" value="" data-clear-btn="true">
			    <label for="select-native-s">Select:</label>
			    <select name="select-native-s" id="select-native-s">
			        <option value="small">One</option>
			        <option value="medium">Two</option>
			        <option value="large">Three</option>
			    </select>
			    <label for="slider-s">Input slider:</label>
			    <input type="range" name="slider-s" id="slider-s" value="25" min="0" max="100" data-highlight="true">
			</form>
            <form>
			    <label for="textinput-s">Text Input:</label>
			    <input type="text" name="textinput-s" id="textinput-s" placeholder="Text input" value="" data-clear-btn="true">
			    <label for="select-native-s">Select:</label>
			    <select name="select-native-s" id="select-native-s">
			        <option value="small">One</option>
			        <option value="medium">Two</option>
			        <option value="large">Three</option>
			    </select>
			    <label for="slider-s">Input slider:</label>
			    <input type="range" name="slider-s" id="slider-s" value="25" min="0" max="100" data-highlight="true">
			</form>
         </div>

         <div data-role = "main" class = "ui-content">
            <h2>Welcome to TutorialsPoint</h2>
            <ul data-role="listview" data-inset="true" data-filter="true">
			    <li><a href="#">Acura</a></li>
			    <li><a href="#">Audi</a></li>
			    <li><a href="#">BMW</a></li>
			    <li><a href="#">Cadillac</a></li>
			    <li><a href="#">Ferrari</a></li>
			</ul>
            <a href="#" data-role="button" data-icon="star" style="vertical-align: top;display:inline-block;width: 20%;margin: 0 2% 0 0;">Star button</a>
         </div>

         <div data-role = "footer">
            <h1>Footer Text</h1>
         </div>
      </div>
   </body>
</html>