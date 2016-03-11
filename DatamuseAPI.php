<?php

/*
 * 
 * 
 */

/**
 * A basic php library for Datamuse RESTful API.
 *
 * @author Moses Simeonidis
 */
class DatamuseAPI {
    
    /**
     * The basic call for the datamuse api. The basic url call is 'https://api.datamuse.com/words'.
     * 
     * @param array $data The parameters of the call.
     * @param String $url The url of the call.
     * @return array 
     */
    public static function callbase( $data , $url = 'https://api.datamuse.com/words' ){
        
        $ch = curl_init();
        
        if ( $data ){
            $url = sprintf( "%s?%s", $url, http_build_query( $data ) );
        }
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)' );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

        $result = curl_exec( $ch );

        curl_close( $ch );
        
        if ( !$result ){
            return array( 'success' => false, 'error' => curl_error( $ch ) );
        }
        
        return json_decode( $result, true );
    }
    
    /**
     * 'Means like constraint' as described at the api page www.datamuse.com/api/
     * 
     * @param type $word The input word or phrase.
     * @param array $options Add more options if is necessary.
     * @return array
     */
    public static function means_like( $word , $limit = 0, $options = array( ) ){
        if( $limit != 0 ){
            $options['max'] = $limit;
        }
        $options['ml'] = $word;
        return self::callbase( $options );

    }
    
    /**
     * 'Sounds like constraint' as described at the api page www.datamuse.com/api/
     * 
     * @param type $word The input word or phrase.
     * @param array $options Add more options if is necessary.
     * @return array
     */
    public static function sounds_like( $word, $limit = 0, $options = array( ) ){
        if( $limit != 0 ){
            $options['max'] = $limit;
        }
        $options['sl'] = $word;
        return self::callbase( $options );
    }

    /**
     * 'Spelled like constraint' as described at the api page www.datamuse.com/api/
     * 
     * @param type $word The input word or phrase.
     * @param array $options Add more options if is necessary.
     * @return array
     */
    public static function spelled_like( $word, $limit = 0 , $options = array( ) ){
        if( $limit != 0 ){
            $options['max'] = $limit;
        }
        $options['sp'] = $word;
        return self::callbase( $options );
    }

    /**
     * Returns a list of similar words to the word/phrase supplied beginning with the specified letter(s).
     * 
     * @param type $word The input word or phrase.
     * @param array $start The letter(s) the similar words should begin with.
     * @return array
     */
    public static function find_similar_starts_with( $word, $start, $limit = 0 ){
        
        return self::means_like( $word, $limit , array( 'sp' => $start."*" ) );
        
    }

    /**
     * Returns a list of similar words to the word/phrase supplied ending with the specified letter(s).
     * 
     * @param type $word The input word or phrase.
     * @param array $start The letter(s) the similar words should begin with.
     * @return array
     */
    public static function find_similar_ends_with( $word, $end, $limit = 0 ){
        
        return self::means_like( $word, $limit, array( 'sp' => "*".$end ) );
    }

    /**
     * Returns a list of words beginning and ending with the specified letters and with the specified number of letters
     * in between. If $num_of_missings is 0 the number of letters are unspecified.
     * 
     * @param String $start The letter(s) the similar words should start with.
     * @param String $end The letter(s) the similar words should end with.
     * @param Integer $num_of_missings The number of letters between the start and end letters
     * @return array
     */
    public static function find_starting_ending_with( $start, $end, $num_of_missings = 0, $limit = 0 ){

        if ( $num_of_missings == 0 ){
            $sb = "*";
        }else{
            $sb = "";
            for ( $i = 0; $i < $num_of_missings; $i++ ) {
               $sb = $sb."?"; 
            }
        }
        
        return self::spelled_like( $start.$sb.$end ,$limit );
    }
    
    /**
     * Returns suggestions for what the user may be typing based on what they have typed so far. Useful for
     * autocomplete on forms.
     * 
     * @param string $word  The current word(s).
     * @return array
     */
    public static function prefix_hint_suggestions( $word ){

        return self::callbase( array( 's' => $word ), 'http://api.datamuse.com/sug' );
    }


}
