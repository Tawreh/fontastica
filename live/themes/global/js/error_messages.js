var quote = new Array();
quote[0] = "<p>\"Proximity alert. Must be coming up on something.\"</p><p>\"Oh my god. What can it be? We're all doomed! Who's flying this thing!? ... Oh right, that would be me. Back to work.\" </p>";
quote[1] = "<p>\"Planet's coming up a mite fast.\"</p><p>\"That's just cause I'm going down too quick. Likely crash and kill us all.\"</p><p>\"Well, that happens, let me know.\"</p>";
quote[2] = "<p>\"Oh! That was bracing. They don't like it when you shoot at them. I worked that out myself.\"</p>";

var i = Math.floor(3*Math.random());

document.write(quote[i]);