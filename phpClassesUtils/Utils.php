<?php

class Utils
{
function isPostSet($POST): bool{
    return $POST && $POST["confirm"] = "confirm";
}
}