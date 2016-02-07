m4_include(b4_pkgdatadir/[c.m4])

# b4_case(LABEL, STATEMENTS)
# --------------------------
m4_pushdef([b4_case],
[  case m4_decr($1):
$2
b4_syncline([@oline@], [@ofile@])
    break;])

# b4_symbol_value(VAL, [TYPE])
# ----------------------------
# Given a semantic value VAL ($$, $1 etc.), extract its value of type
# TYPE if TYPE is given, otherwise just return VAL.  The result can be
# used safetly, it is put in parens to avoid nasty precedence issues.
# TYPE is *not* put in braces, provide some if needed.
m4_pushdef([b4_symbol_value],
[$1[]m4_ifval([$2], [.$2])])

## ----------------- ##
## Semantic Values.  ##
## ----------------- ##


# b4_lhs_value([TYPE])
# --------------------
# Expansion of $<TYPE>$.
m4_define([b4_lhs_value],
[b4_symbol_value($m4_quote(b4_prefix)val, [$1])])


# b4_rhs_value(RULE-LENGTH, NUM, [TYPE])
# --------------------------------------
# Expansion of $<TYPE>NUM, where the current rule has RULE-LENGTH
# symbols on RHS.
m4_define([b4_rhs_value],
          [b4_symbol_value([$b4_prefix@{b4_subtract([$2], [0])@}], [$3])])


## ----------- ##
## Locations.  ##
## ----------- ##

# b4_lhs_location()
# -----------------
# Expansion of @$.
m4_define([b4_lhs_location],
[$m4_quote(b4_prefix)loc])


# b4_rhs_location(RULE-LENGTH, NUM)
# ---------------------------------
# Expansion of @NUM, where the current rule has RULE-LENGTH symbols
# on RHS.
m4_define([b4_rhs_location],
          [$m4_quote(b4_prefix)loc@{b4_subtract([$2], [0])@}])

b4_output_begin([b4_parser_file_name])
<?php

$reduceCallback = function ($ruleNumber, $b4_prefix, b4_lhs_location) {
  b4_user_pre_prologue
  switch ($ruleNumber) {
  	b4_user_actions
    default: b4_lhs_value() = count($m4_quote(b4_prefix)) ? b4_rhs_value(0, 0) : null; break;
  }
  return $m4_quote(b4_prefix)val;
}

?>
b4_output_end()
