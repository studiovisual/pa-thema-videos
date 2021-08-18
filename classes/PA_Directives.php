<?php

use Illuminate\Support\Str;

blade_directive('videolength', function($expression) {
    if(empty($expression))
        return "<?= videoLength() ?>";

    return "<?= videoLength({$expression}) ?>";
});

blade_directive('hasfield', function($expression) {
    if(Str::contains($expression, ',')):
        $expression = PA_Util::parse($expression);

        return "<?php if(get_field({$expression->get(0)}, {$expression->get(1)})): ?>";
    endif;

    return "<?php if(get_field({$expression})): ?>";
});

blade_directive('endfield', function() {
    return "<?php endif; ?>";
});