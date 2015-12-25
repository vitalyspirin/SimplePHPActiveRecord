<?php

class Data
{
    public static $dataForNotNullColumnsArray = [
        'col_bit2' => 2, // valid max is only 1
        'col_bit4' => 3, // valid max is only 1
        'col_bit6' => 4, // valid max is only 3
        'col_tinyint2' => 128, // valid max is only 127
        'col_tinyint4' => 256, // valid max is only 255
        'col_bool2' => 2,
        'col_boolean2' => 2,
        'col_smallint2' => 32768, // valid max is only 32767
        'col_smallint4' => 65536, // valid max is only 65535
        'col_mediumint2' => 8388608, // valid max is only 8388607
        'col_mediumint4' => 16777216, // valid max is only 16777215
        'col_int2' => 2147483648, // valid max is only 2147483647
        'col_int4' => 4294967296, // valid max is only 4294967295
        'col_integer2' => 2147483648, // valid max is only 2147483647
        'col_integer4' => 4294967296, // valid max is only 4294967295
        'col_bigint2' => 9223372036854775808, // valid max is only 9223372036854775807
        'col_bigint4' => 9223372036854775807, // MySQL valid max is only 18446744073709551615
                                              // but PHP doesn't support unsigned integer
        'col_decimal2' => 1,
        'col_decimal4' => 2,
        'col_dec2' => 3,
        'col_dec4' => 4,
        'col_float2' => 3.402823466E+39, // valid max is only 3.402823466E+38
        'col_float4' => -3.402823466E+39,// valid min is only -3.402823466E+38
        'col_double2' => 1.7976931348623157E+309, // valid max is only 1.7976931348623157E+308
        'col_double4' => 1.7976931348623157E+309, // valid max is only 1.7976931348623157E+308
        'col_doubleprecision2' => 1.7976931348623157E+309,
        'col_doubleprecision4' => 1.7976931348623157E+309,
        
        'col_char2' => '123',
        'col_char4' => '123',
        'col_varchar2' => '1234',
        'col_binary2' => '12',
        'col_binary4' => '123',
        'col_varbinary2' => '1234',
        'col_tinyblob2' => 101,
        'col_tinytext2' => 102,
        'col_blob2' => 103,
        'col_text2' => 104,
        'col_mediumblob2' => 105,
        'col_mediumtext2' => 106,
        'col_longblob2' => 107,
        'col_longtext2' => 108,
        
        'col_enum2' => 'val1',
        'col_set2' => 'val2',
        'col_date2' => '999-01-01',
        'col_datetime2' => '999-01-01 00:00:00.000000',
        'col_time2' => '839:59:59.000000' // valid max is only '838:59:59.000000'
    ]; 

        
    public static $dataStrictSQLValidForNotNullColumnsArray = [
/*        'col_bit2' => true,
        'col_bit4' => false,
        'col_bit6' => 3,*/
        'col_tinyint2' => 127, // valid max is only 127
        'col_tinyint4' => 255, // valid max is only 255
        'col_smallint2' => 32767, // valid max is only 32767
        'col_smallint4' => 65535, // valid max is only 65535
        'col_mediumint2' => 8388607, // valid max is only 8388607
        'col_mediumint4' => 16777215, // valid max is only 16777215
        'col_int2' => 2147483647, // valid max is only 2147483647
        'col_int4' => 4294967295, // valid max is only 4294967295
        'col_integer2' => 2147483647, // valid max is only 2147483647
        'col_integer4' => 4294967295, // valid max is only 4294967295
    //    'col_bigint2' => 9223372036854775807, // valid max is only 9223372036854775807
    //    'col_bigint4' => 9223372036854775807, // valid max is only 9223372036854775807
        
        'col_float2' => 3.402823466E+38, // valid max is only 3.402823466E+38
        'col_float4' => 3.402823466E+38,// valid max is only 3.402823466E+38
        'col_double2' => 1.7976931348623157E+308, // valid max is only 1.7976931348623157E+308
        'col_double4' => 1.7976931348623157E+308, // valid max is only 1.7976931348623157E+308
        'col_doubleprecision2' => 1.7976931348623157E+308,
        'col_doubleprecision4' => 1.7976931348623157E+308,
        
        'col_char2' => '1',    
        'col_char4' => '12',
        'col_varchar2' => '123',
        'col_binary2' => '1',
        'col_binary4' => '12',
        'col_varbinary2' => '123',
        
        'col_enum2' => 'value1',
        'col_set2' => 'value2',

        'col_time2' => '838:59:59' // valid max is only '838:59:59.000000'
    ];

}
