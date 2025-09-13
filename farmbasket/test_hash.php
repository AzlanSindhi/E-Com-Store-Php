<?php
$plain = "admin123";
$hash = '$2y$10$w7Z1XtI5kjxYgUe0iZPmeOZ3fR2JjnnmYeG08Pv5gwFUlNztzjpmG';

if (password_verify($plain, $hash)) {
    echo "✅ Password matches";
} else {
    echo "❌ Password does NOT match";
}
