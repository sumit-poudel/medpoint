<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MedPoint</title>
  <link rel="icon" type="image/png" href="public/med-logo.png">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Edu+NSW+ACT+Cursive:wght@400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
  </style>
  <style type="text/tailwindcss">
    body{
      background: #f5f5f5;
    }
    @theme {
  --font-heading: "Inter";
  --font-logo: "Edu NSW ACT Cursive";
  --color-med-lime: #28A745;
  --color-ash: #E4E4E4;
  --color-txt-ash: #666666;
  --color-bdr-ash: #CECECE;
  --color-med-drklime: #304D30;
  --color-main-green: #044343;
  --color-main-gray: #BDC3C6;
  --color-main-black: #263238;
}
@layer base{
  button{
   cursor: pointer;
  }
}
@layer components{
   .share{
       border: 2px solid var(--color-med-lime);
       transition: all 0.3s ease;
   }
}
    </style>
</head>
