<?php
/**
 * GraphML Generator v0.1b
 *
 * Requirements: PHP5
 *
 * GraphML Generator is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, version 3 of the License, or
 * (at your option) any later version.
 *
 * 
 * GraphML is a very basic UML generator script and it is in beta status.
 * The script processes only .php files which has classes.
 * The generated UML can be viewed in yEd (http://www.yworks.com/en/products_yed_about.html)
 * or any graph editor program that can read .graphml files.
 * 
 * If you have any questions don't hesitate to conctact me.
 * 
 * @package  GraphML Generator
 * @author   Janos Tucsek <tucsi@tucsi.hu>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL
 * @link     http://www.tucsi.hu/graphml/
 * @date     2010-02-19
 * @updated  2010-03-05
 */


error_reporting(E_ALL);
ini_set('display_errors', 1 );


define( '_MAX_NODE_HEIGHT', 50 );
define( '_MAX_NODE_PER_COLUMN', 5 );

class generateGraphML
{
    protected $sDirectory;                                                      /* initial directory, there will be the graphml file stored */
    protected $iNodeYPos = 10;
    protected $iNodeNumber = 0;
    protected $iNodeRows = 1;
    protected $iNodeColumn = 1;
    protected $iMaxNodeHeight = _MAX_NODE_HEIGHT;

    protected $iEdgeNumber = 0;

    protected $sNodeTemplate;
    protected $sEdgeTemplate;
    protected $sFullTemplate;
    protected $sGeneratedNodes;
    protected $sGeneratedEdges;

    protected $aMethods;
    protected $aAttributes;
    protected $sClassName;

    protected $aEdgeData = array();
    protected $aClassData = array();

    protected $sBaseDir;
    protected $sTemplateDir = 'templates/';

    protected $aProcessedDirectories = array();

    /**
     * Constructor and executor
     *
     * @param string $sDirectory  Initial directory, this is the first dir where .php files will be searched
     * @param string $sExcludeDir Don't read directories matching $sExcludeDir
     */
    public function __construct( $sDirectory = '.', $sExcludeDir = '' )
    {
        $this->sBaseDir = dirname(__FILE__) . '/';

        $this->sDirectory = $sDirectory;

        /* Let's read the template files */
        if ( is_file( $this->sBaseDir . $this->sTemplateDir . 'node.tpl' ) )
        {
            $this->sNodeTemplate = file_get_contents( $this->sBaseDir . $this->sTemplateDir . '/node.tpl' );
        } else {
            echo 'Node template file not found, exiting.' . "\n";
            exit(1);
        }
        if ( is_file( $this->sBaseDir . $this->sTemplateDir . '/edge.tpl' ) )
        {
            $this->sEdgeTemplate = file_get_contents( $this->sBaseDir . $this->sTemplateDir . '/edge.tpl' );
        } else {
            echo 'Edge template file not found, exiting.' . "\n";
            exit(1);
        }
        if ( is_file( $this->sBaseDir . $this->sTemplateDir . '/full.tpl' ) )
        {
            $this->sFullTemplate = file_get_contents( $this->sBaseDir . $this->sTemplateDir . '/full.tpl' );
        } else {
            echo 'Full template file not found, exiting.' . "\n";
            exit(1);
        }

        /* Search for .php files */
        $this->walkDir( $this->sDirectory, $sExcludeDir );

        /* Create edges between objects */
        $this->createEdges();

        /* Finally generate the graphml file */
        $this->createFullGraphML();
    }

    /**
     *
     * Process .php files in directory
     *
     * @param string $sDirectory
     */
    protected function collectFiles( $sDirectory = '.' )
    {
        if ( isset( $this->aProcessedDirectories[ $sDirectory ] ) )
        {
            return ;
        }

        $this->aProcessedDirectories[ $sDirectory ] = true;
        foreach ( glob($sDirectory . '/*.php') as $sCurrentFile )
        {
            echo 'Processing file: ' . $sCurrentFile . ' - ';
            $this->processFile( $sCurrentFile );
            echo 'Done' . "\n";
        }
    }


    /**
     *
     * Walk recursively directories for .php files
     * 
     * @param string $sDirectory   Search for .php files in $sDirectory
     * @param string $sExcludeDir (optional) Don't read directories matching $sExcludeDir
     */
    protected function walkDir( $sDirectory, $sExcludeDir = '' )
    {
        if ( $rDh = opendir( $sDirectory ) )
        {
            $this->collectFiles( $sDirectory );
            while ( ( $sCurrentFile = readdir( $rDh ) ) !== false )
            {
                if ( $sCurrentFile == '.' || $sCurrentFile == '..' ) continue;

                if ( $sCurrentFile == $sExcludeDir ) continue;

                if ( is_dir( $sDirectory . '/' . $sCurrentFile ) )
                {
                    /* Current file is a directory, so entering into it */
                    $this->walkDir( $sDirectory . '/' . $sCurrentFile, $sExcludeDir );
                    
                    /* Search and parse .php files in the given directory */
                    $this->collectFiles( $sDirectory . '/' . $sCurrentFile );
                }
            }
            closedir( $rDh );
        }
    }

    
    /**
     *
     * Process .php file
     *
     * @param string $sFileName filename to process
     */
    protected function processFile( $sFileName )
    {

        $this->sClassName = '';
        $this->aAttributes = array();
        $this->aMethods = array();
        
        if ( ! is_file( $sFileName ) )
        {
            return false;
        }

        if ( $sContent = file_get_contents( $sFileName ) )
        {
            /* Remove comments */
            $sContent = preg_replace('/(\/\/.*)/i', '', $sContent );
            $sContent = preg_replace('/(\/\*(.*)\*\/)/imsU', '', $sContent );

            /* Search for a class name and extends if it exists */
            if ( preg_match( '/class ([a-z0-9\_]+)( extends ([a-z0-9\_]+))*/im', $sContent, $aMatchResult ) )
            {
                $this->sClassName = ucfirst( strtolower( $aMatchResult[1] ) );

                /* Class has extends */
                if ( !empty( $aMatchResult[3] ) )
                {
                    $this->aEdgeData[ $this->sClassName ] = ucfirst( strtolower( $aMatchResult[3] ) );
                }

                $this->aClassData[ $this->sClassName ] = $this->iNodeNumber;
            }

            /* If it's not a class, then we won't work with it */
            if ( empty( $this->sClassName ) )
            {
                return ;
            }

            /* Search for methods regardless of their accessibility (protected|public|private, etc) */
            if ( preg_match_all( '/function ([a-z0-9\_\(\)\$=\'\"\., ]+)/im', $sContent, $aMatchResult ) )
            {
                foreach ( $aMatchResult[1] as $sCurrentMethodName )
                {
                    $this->aMethods[] = $sCurrentMethodName;
                }
            }

            /* Search for properties */
            if ( preg_match_all( '/(protected|private|public|var) (static )*\$([a-z0-9\_\=\'\"\. ]+)/im', $sContent, $aMatchResult ) )
            {
                foreach ( $aMatchResult[3] as $sCurrentAttributeName )
                {
                    $this->aAttributes[] = $sCurrentAttributeName;
                }
            }
        }

        /* If it's not a class, then we won't work with it */
        if ( !empty( $this->sClassName ) )
        {
            $this->createNodes();
        }

        return ;
    }


    /**
     *
     * Ok, we have a parsed .php file, so let's create a node for it in the graph
     *
     */
    protected function createNodes()
    {
        $iNodeHeight = (count($this->aAttributes)+count($this->aMethods))*15+50;
        if ( $iNodeHeight > $this->iMaxNodeHeight )
        {
            $this->iMaxNodeHeight = $iNodeHeight;
        }

        $aSearchFor     = array('%%node_id%%',
                                '%%node_x%%',
                                '%%node_y%%',
                                '%%class_name%%',
                                '%%node_stereotype%%',
                                '%%node_attributes%%',
                                '%%node_methods%%',
                                '%%node_height%%' );
        $aReplaceWith = array(  $this->iNodeNumber++,
                                ($this->iNodeColumn*200),
                                ($this->iNodeYPos),
                                $this->sClassName,
                                '',
                                implode("\n", $this->aAttributes),
                                implode("\n", $this->aMethods ),
                                $iNodeHeight );

        $this->sGeneratedNodes .= str_replace( $aSearchFor, $aReplaceWith, $this->sNodeTemplate );

        /* If we reach the maximum node in the given row then "create" a new row */
        if ( $this->iNodeNumber % _MAX_NODE_PER_COLUMN == 0 )
        {
            $this->iLastNodeRows = $this->iNodeRows;
            $this->iNodeRows++;
            $this->iNodeColumn = 0;
            $this->iNodeYPos += $this->iMaxNodeHeight + 50;
            $this->iMaxNodeHeight = _MAX_NODE_HEIGHT;
        }
        $this->iNodeColumn++;
    }


    /**
     *
     * This method is for finding relations between classes and creates the appropriate edges
     *
     */
    protected function createEdges()
    {
        $this->sGeneratedEdges = '';
        foreach ( $this->aEdgeData as $sTargetClassName => $sSourceClassName )
        {
            if ( !isset( $this->aClassData[ $sSourceClassName ] ) || !isset( $this->aClassData[ $sTargetClassName ] ) )
            {
                continue;
            }

            $aSearchFor   = array( '%%edge_id%%',
                                   '%%source_node%%',
                                   '%%target_node%%' );
            $aReplaceWith = array( $this->iEdgeNumber++,
                                   $this->aClassData[ $sSourceClassName ],
                                   $this->aClassData[ $sTargetClassName ] );

            $this->sGeneratedEdges .= str_replace( $aSearchFor, $aReplaceWith, $this->sEdgeTemplate );
        }

    }


    /**
     *
     * Creates graphml file in initial directory
     *
     */
    protected function createFullGraphML()
    {
        $sContent = str_replace('%%nodes%%', $this->sGeneratedNodes, $this->sFullTemplate );
        $sContent = str_replace('%%edges%%', $this->sGeneratedEdges, $sContent );

        if ( $rFp = fopen( $this->sDirectory . '/uml-' . date('YmdHis') . '.graphml', 'w' ) )
        {
            fputs( $rFp, $sContent );
            fclose( $rFp );
        }
    }
}



$oGraphMLGenerator = new generateGraphML( 'application/models' );
