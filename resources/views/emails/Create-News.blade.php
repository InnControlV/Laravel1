<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Jarb Website</title>
  <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/Create.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- Header and Sidebar will be loaded here -->
<div id="header-placeholder"></div>
<div class="container">
  <div id="sidebar-placeholder"></div>


   <main style="flex: 1; padding: 0; overflow-y: auto; background-color: #f5f6fa;">
  <div style="background: white; padding: 30px; width: 100%; height: 100%;">
    <h2 style="margin-top: 0; color: #333;">Create News</h2>
    <form style="display: flex; flex-wrap: wrap; gap: 20px;" enctype="multipart/form-data" method="POST" action="/submit-form">
      <input type="hidden" name="id" value="123">

      <div style="flex: 1 1 30%;">
        <label for="category">Category</label>
        <select id="category" name="category" class="form-control">
          <option value="tech">Tech</option>
          <option value="news">News</option>
          <option value="sports">Sports</option>
        </select>
      </div>

      <div style="flex: 1 1 30%;">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" class="form-control">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="language">Language</label>
        <select id="language" name="language" class="form-control">
          <option value="en">English</option>
          <option value="hi">Hindi</option>
          <option value="fr">French</option>
        </select>
      </div>

      <div style="flex: 1 1 30%;">
        <label for="location">Location</label>
        <select id="location" name="location" class="form-control">
          <option value="delhi">Delhi</option>
          <option value="mumbai">Mumbai</option>
          <option value="bangalore">Bangalore</option>
        </select>
      </div>

      <div style="flex: 1 1 30%;">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" accept="image/*" class="form-control">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" class="form-control">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="time">Time</label>
        <input type="time" id="time" name="time" class="form-control">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="referFrom">Refer From</label>
        <input type="text" id="referFrom" name="referFrom" class="form-control">
      </div>

      <div style="flex: 1 1 30%;">
        <label for="link">Link</label>
        <input type="url" id="link" name="link" class="form-control">
      </div>

      <div style="flex: 1 1 48%;">
        <label for="favourite">Favourite</label>
        <select id="favourite" name="favourite" class="form-control">
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
      </div>

      <div style="flex: 1 1 48%;">
        <label for="details">Details</label>
        <textarea id="details" name="details" class="form-control" style="height: 40px; resize: none;"></textarea>
      </div>

      <div style="flex: 1 1 100%;">
        <label for="shortDescription">Short Description</label>
        <textarea id="shortDescription" name="shortDescription" rows="3" class="form-control"></textarea>
      </div>

      <div style="flex: 1 1 100%; text-align: right; margin-top: 20px;">
        <button type="submit" style="
          padding: 10px 25px;
          background-color: #007bff;
          color: white;
          border: none;
          border-radius: 5px;
          cursor: pointer;
        ">Create News</button>
      </div>
    </form>
  </div>
</main>

 

<script src="js/script.js"></script>
</body>
</html>
