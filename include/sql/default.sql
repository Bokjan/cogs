<?

//��settings
$sql="delete from settings";
$p->dosql($sql);
$sql="insert into settings values('1','global_sitename','CmYkRgB123 Online Grading System')";
$p->dosql($sql);
$sql="insert into settings values('2','global_adminname','CmYkRgB123')";
$p->dosql($sql);
$sql="insert into settings values('3','global_adminaddress','http://www.cmykrgb123.com')";
$p->dosql($sql);
$sql="insert into settings values('4','global_constructiontime','1213849886')";
$p->dosql($sql);
$sql="insert into settings values('5','global_root','cojs/')";
$p->dosql($sql);
$sql="insert into settings values('6','style_profile','2.css')";
$p->dosql($sql);
$sql="insert into settings values('7','style_jumptime','1')";
$p->dosql($sql);
$sql="insert into settings values('8','style_pagesize','10')";
$p->dosql($sql);
$sql="insert into settings values('9','style_ranksize','20')";
$p->dosql($sql);
$sql="insert into settings values('10','style_defstring','chinese.php')";
$p->dosql($sql);
$sql="insert into settings values('11','reg_defgroup','1')";
$p->dosql($sql);
$sql="insert into settings values('12','reg_readfroce','1')";
$p->dosql($sql);
$sql="insert into settings values('13','limit_regallow','1')";
$p->dosql($sql);
$sql="insert into settings values('14','limit_siteopen','1')";
$p->dosql($sql);
$sql="insert into settings values('15','limit_checker','0')";
$p->dosql($sql);
$sql="insert into settings values('16','prob_deftimelimit','1000')";
$p->dosql($sql);
$sql="insert into settings values('17','prob_defdifficulty','1')";
$p->dosql($sql);
$sql="insert into settings values('18','global_index','<h1 align=\"center\"><strong>����ʡʵ����ѧ</strong></h1>
<h1 align=\"center\"><strong>��Ϣѧ(�����)����ƥ�˾�����������ϵͳ</strong></h1>
<p style=\"font-size: 16px;\">ȫ����������Ϣѧ����ƥ�˾���(National Olympiad in Informatics, ���NOI)��һ������ȫ�����������Ϣѧ�������ռ����ּ������Щ����ѧ�׶�ѧϰ���������ռ��������ѧ֪ʶ����ѧУ����Ϣ���������γ��ṩ�������µ�˼·������Щ�вŻ���ѧ���ṩ�໥������ѧϰ�Ļ��᣻ͨ����������صĻ������ѡ������ļ�����˲š�<br />
������Ŀ����Ϊ���ڸ��߲�����ƶ��ռ���������������ػ��ѭ������ԭ���κ�������������Ȥ��ѧУ�͸��ˣ���������ҵ��ʱ����Ը�μӡ�����������е�ѧУ��ѧ���ͻ��Ҳ�������ѧ�ƻ����ǿ������ʵ����ʩ�̻���μ��߿�Ϊ���л���е�ѧ����</p>
<p style=\"font-size: 16px;\">��ϵͳΪ�����ύ����ϵͳ</p>
<p>������:<a href=\"http://www.cmykrgb123.com/\" target=\"_blank\">CmYkRgB123</a> ָ����ʦ:������</p>
<p>���� <a href=\"http://192.168.1.252/os/\" target=\"_blank\">����ʡʵ����ѧ��Ϣѧ(�����)����ƥ�˾�������ѧϰϵͳ </a></p>')";
$p->dosql($sql);
$sql="insert into settings values('23','global_head','<div align=\"center\" class=\"Title\">%global_sitename%</div>
<hr class=\"Spliter\" />')";
$p->dosql($sql);
$sql="insert into settings values('19','style_portrait','91')";
$p->dosql($sql);
$sql="insert into settings values('20','dir_databackup','/home/cojs/dbbackup')";
$p->dosql($sql);
$sql="insert into settings values('21','dir_source','/home/cojs/source')";
$p->dosql($sql);
$sql="insert into settings values('22','dir_competition','/home/cojs/competition')";
$p->dosql($sql);
$sql="insert into settings values('24','global_tail','<hr class=\"Spliter\" />
<p><span class=\"Tail\">
<li>����������Ϊ��������ύ�ƻ�����ϵͳ�Ķ�����룬�����Ϊ�ᱻϵͳ��¼�����ǽ�����֤�ݲ���ȡ��ʩ���Ʋ÷Ƿ����ƻ��ߡ�</li>
</span><span align=\"center\" class=\"Tail\">Using style %style_profile%. Processd in %processtime% s, %querytimes% database queries. Copyright ��<a target=\"_blank\" href=\"http://www.cmykrgb123.com\">CmYkRgB123</a> ,All rights reserverd.</span></p>')";
$p->dosql($sql);
$sql="insert into settings values('25','global_about','<p>%global_sitename%</p>
<p>����Ա <a href=\"%global_adminaddress%\">%global_adminname%</a></p>
<p>��վʱ�� %constructiontime%</p>')";
$p->dosql($sql);
$sql="insert into settings values('26','global_help','<table width=\"100%\" border=\"1\">
      <tr>
        <td><li>������˵��</li>
          <p>����ÿ�����Ե㣬��ʹ��һ��Ӣ�Ĵ�д��ĸ����ʾ�ò��Ե����������</p>
          <table border=\"0\">
            <tr>
              <td>A</td>
              <td>��ȷ</td>
            </tr>
            <tr>
              <td>W</td>
              <td>����</td>
            </tr>
            <tr>
              <td>T</td>
              <td>����ʱ������</td>
            </tr>
            <tr>
              <td>E</td>
              <td>����ʱ����</td>
            </tr>
            <tr>
              <td>R</td>
              <td>û������ļ�</td>
            </tr>
            <tr>
              <td>C</td>
              <td>����ʧ��</td>
            </tr>
            <tr>
              <td>N</td>
              <td>û���ҵ�Դ�ļ�</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td><li>Ϊʲô�������ҵĵ������ܹ��������У���������ϵͳ�ϲ���?</li>
		<ol>
          <li>����ϵͳ������Ubuntu Linux 7.10�£�����������gcc,g++,freepascal.����ϵͳ�ڱȽ�������ʱĬ�ϲ��ú���һ����Ч�ַ�(�ո�,�س���)
          �Ĳ��ԡ�</li>
		  <li>����ϵͳ����ĳ����ڴ��ʹ�ý������ƣ�Ĭ��Ϊ256MB��ͬʱҲ����ĳ����ջ��ʹ�ý������ơ������ĳ���ʹ�õݹ���100,000��(��������)����ô��ĳ���ܿ�������ʱ����</li>
		  <li>����C��C++���ԣ�������һ��Ҫ����Ϊint main()������void main()�������ĳ�����������������Ӧ��ϵͳ����һ������ֵ0�������������Ķ�����</li>
		  <li>����ϵͳ����ĵ���ʹ�õ��ڴ氲�ŷ�ʽ���ܲ�ͬ��ĳЩ����ĵ�����û�о�����ʼ������ӦΪ0�ı���������ϵͳ���п��ܲ������������������</li>
		  <li>Linux���ڴ�ķ��ʿ��Ƹ�Ϊ�ϸ������Windows�Ͽ����������е���Чָ��������±����Խ�磬������ϵͳ���޷����С�</li>
		  <li>�ڴ�й¶������ܿ��ܻ�����ϵͳ�ı���ģ��ɱ����Ľ��̡���ˣ�����ʹ��malloc(��calloc,realloc,new)������õ��ڴ�ռ䣬��ʹ��free(��delete)��ȫ�ͷš�</li>
		  <li>�ڼ���������£���ĳ������д���(�����ʧ��)����Ϊ��ʹ�õ�ĳЩ���������ϵͳ�ı������������ظ�(����:mmap,qsort)�������������⣬��ֻ�ó����滻ĳЩ������ϵͳ�������ظ��ı�������</li>
		  <li>ע�⸡�����㣬�����Ƹ����������ʱ����п��ܻ�������벻���Ĳ��졣����a=0.00001+0.000001;</li>
		  <li>����һ�ַ�������������������ϵͳ��ֱ�ӵ��Գ��������ʹ��assert��(C/C++)�����߰���Ҫ�۲�ı��������stderr(C)��cerr(C++)��(Pascal�ƺ�����)</li>
		  <li>�������������ϵ����ԣ���������Ĵ��롰���롱����һ������Ȼ���ύ�������ڷ����ʱ����ᷢ����ĳ���Ĵ�����������Ժ��ܹ�����ͨ������ô����ϸ�����ԭ���ĳ���</li>
		  <li>������϶��޷�������⣬�������Ա��ϵ��������ϵ���ߣ�<a href=\"http://www.cmykrgb123.com\" target=\"_blank\">CmYkRgB123</a>��</li>
		  </ol>
		  </td>
      </tr>
      <tr>
        <td><li>ϵͳ����</li>
		  <ol>
			<li>�Ѿ��������Ҳ������ɼ��ı����Զ����ء�</li>
			<li>ɾ���û�ʱ����ɾ�����û��������ύ��¼���ύ�ļ������ۡ�������¼�����û���������Ŀ������������Ȩ��ת�Ƶ�������Ա�û���</li>
			<li>ɾ������ʱ����ɾ�����й����ñ����ĳ��Ρ�</li>
			<li>ɾ����������ʱ����ɾ�����й����ó��ε��ύ��¼���ύ�ļ���</li>
		</ol>
		</td>
      </tr>
    </table>')";
$p->dosql($sql);

?>