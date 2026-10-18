<?php
/**
 * Plugin Name: PAH FAQ Schema Generator
 * Plugin URI:  https://proarticleshub.com/faq-schema-generator/
 * Description: Free FAQ schema generator. Adds the [pah_faq_schema_generator] shortcode that builds valid FAQPage JSON-LD in the browser.
 * Version:     1.0.0
 * Author:      Kamran Liaquat Ali
 * Author URI:  https://proarticleshub.com/about-us/
 * License:     MIT
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * FAQ Schema Generator - shortcode [pah_faq_schema_generator]
 * Runs entirely in the browser. No data is sent to the server.
 */
function pah_faq_schema_generator_shortcode() {
    $html = <<<'PAHHTML'
<div class="pah-faqgen" id="pah-faqgen">
  <style>
    .pah-faqgen{--b:#2563eb;--bd:#dbe3ef;--bg:#f8fafc;--tx:#0f172a;--mu:#64748b;--ok:#15803d;--wa:#b45309;border:1px solid var(--bd);border-radius:14px;padding:20px;background:#fff;color:var(--tx);font-size:16px;margin:0 0 28px}
    .pah-faqgen h2.pah-fg-title{margin:0 0 4px;font-size:24px;border:0;padding:0}
    .pah-faqgen .pah-fg-sub{margin:0 0 16px;color:var(--mu);font-size:15px}
    .pah-faqgen .pah-fg-row{border:1px solid var(--bd);border-radius:10px;padding:14px;margin:0 0 12px;background:var(--bg)}
    .pah-faqgen .pah-fg-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;font-weight:600;font-size:14px;color:var(--mu)}
    .pah-faqgen label{display:block;font-size:14px;font-weight:600;margin:6px 0 4px}
    .pah-faqgen input[type=text],.pah-faqgen textarea{width:100%;box-sizing:border-box;border:1px solid var(--bd);border-radius:8px;padding:10px;font:inherit;font-size:15px;background:#fff;color:var(--tx)}
    .pah-faqgen textarea{min-height:80px;resize:vertical}
    .pah-faqgen .pah-fg-btns{display:flex;flex-wrap:wrap;gap:8px;margin:12px 0}
    .pah-faqgen button{border:0;border-radius:8px;padding:10px 16px;font:inherit;font-size:15px;font-weight:600;cursor:pointer;background:#e2e8f0;color:var(--tx)}
    .pah-faqgen button.pah-fg-primary{background:var(--b);color:#fff}
    .pah-faqgen button.pah-fg-remove{background:transparent;color:#b91c1c;padding:4px 8px;font-size:13px}
    .pah-faqgen button:focus-visible{outline:3px solid #93c5fd;outline-offset:2px}
    .pah-faqgen .pah-fg-opts{display:flex;flex-wrap:wrap;gap:16px;font-size:14px;margin:6px 0}
    .pah-faqgen .pah-fg-opts label{display:inline-flex;gap:6px;align-items:center;font-weight:500;margin:0}
    .pah-faqgen pre.pah-fg-out{background:#0f172a;color:#e2e8f0;border-radius:10px;padding:14px;overflow:auto;max-height:380px;font-size:13px;line-height:1.5;white-space:pre-wrap;word-break:break-word;margin:0}
    .pah-faqgen .pah-fg-msgs{margin:10px 0 0;padding:0;list-style:none;font-size:14px}
    .pah-faqgen .pah-fg-msgs li{padding:4px 0}
    .pah-faqgen .pah-fg-ok{color:var(--ok)} .pah-faqgen .pah-fg-warn{color:var(--wa)}
    .pah-faqgen .pah-fg-stats{font-size:14px;color:var(--mu);margin:8px 0}
    .pah-faqgen .pah-fg-copied{color:var(--ok);font-size:14px;margin-left:6px}
  </style>
  <h2 class="pah-fg-title">FAQ Schema Generator</h2>
  <p class="pah-fg-sub">Add your questions and answers, then copy the ready-to-use FAQPage JSON-LD code.</p>
  <div class="pah-fg-rows" id="pah-fg-rows"></div>
  <div class="pah-fg-btns">
    <button type="button" id="pah-fg-add">+ Add question</button>
    <button type="button" id="pah-fg-sample">Load example</button>
    <button type="button" id="pah-fg-clear">Clear all</button>
  </div>
  <div class="pah-fg-opts">
    <label><input type="checkbox" id="pah-fg-wrap" checked> Wrap in &lt;script&gt; tag</label>
    <label><input type="checkbox" id="pah-fg-pretty" checked> Pretty print</label>
  </div>
  <div class="pah-fg-stats" id="pah-fg-stats" aria-live="polite"></div>
  <pre class="pah-fg-out" id="pah-fg-out" aria-label="Generated FAQ schema code"></pre>
  <div class="pah-fg-btns">
    <button type="button" class="pah-fg-primary" id="pah-fg-copy">Copy code</button><span class="pah-fg-copied" id="pah-fg-copied" aria-live="polite"></span>
  </div>
  <ul class="pah-fg-msgs" id="pah-fg-msgs" aria-live="polite"></ul>
</div>
<script>
(function(){
  var root=document.getElementById('pah-faqgen'); if(!root||root.dataset.ready){return;} root.dataset.ready='1';
  var rows=document.getElementById('pah-fg-rows'), out=document.getElementById('pah-fg-out'), msgs=document.getElementById('pah-fg-msgs'), stats=document.getElementById('pah-fg-stats');
  var wrap=document.getElementById('pah-fg-wrap'), pretty=document.getElementById('pah-fg-pretty'), copied=document.getElementById('pah-fg-copied');
  var n=0;
  function addRow(q,a){
    n++; var id='pah-fg-'+n; var d=document.createElement('div'); d.className='pah-fg-row';
    d.innerHTML='<div class="pah-fg-head"><span class="pah-fg-num"></span><button type="button" class="pah-fg-remove">Remove</button></div>'+
      '<label for="'+id+'-q">Question</label><input type="text" id="'+id+'-q" class="pah-fg-q" placeholder="e.g. How long does SEO take to work?">'+
      '<label for="'+id+'-a">Answer</label><textarea id="'+id+'-a" class="pah-fg-a" placeholder="Write a complete, helpful answer."></textarea>';
    d.querySelector('.pah-fg-q').value=q||''; d.querySelector('.pah-fg-a').value=a||'';
    d.querySelector('.pah-fg-remove').addEventListener('click',function(){d.remove(); if(!rows.children.length){addRow();} render();});
    d.addEventListener('input',render); rows.appendChild(d); render();
  }
  function items(){
    return Array.prototype.map.call(rows.children,function(r){return {q:r.querySelector('.pah-fg-q').value.trim(),a:r.querySelector('.pah-fg-a').value.trim()};});
  }
  function render(){
    Array.prototype.forEach.call(rows.children,function(r,i){r.querySelector('.pah-fg-num').textContent='Question '+(i+1);});
    var all=items(), ok=all.filter(function(x){return x.q&&x.a;}), m=[];
    var data={'@context':'https://schema.org','@type':'FAQPage','mainEntity':ok.map(function(x){return {'@type':'Question','name':x.q,'acceptedAnswer':{'@type':'Answer','text':x.a}};})};
    var json=JSON.stringify(data,null,pretty.checked?2:0).replace(/<\//g,'<\\/');
    out.textContent=ok.length?(wrap.checked?'<script type="application/ld+json">\n'+json+'\n</'+'script>':json):'Add at least one question and answer to generate the code.';
    var seen={};
    all.forEach(function(x,i){
      var k='Question '+(i+1)+': ';
      if(!x.q&&!x.a){return;}
      if(!x.q){m.push(['warn',k+'question is empty, so this item is skipped.']);}
      else if(!x.a){m.push(['warn',k+'answer is empty, so this item is skipped.']);}
      if(x.q&&x.q.slice(-1)!=='?'){m.push(['warn',k+'questions usually end with a question mark.']);}
      if(x.a&&x.a.split(/\s+/).length<8){m.push(['warn',k+'the answer is very short. Give a complete answer.']);}
      var key=x.q.toLowerCase(); if(x.q&&seen[key]){m.push(['warn',k+'duplicates an earlier question.']);} seen[key]=1;
    });
    if(ok.length){m.unshift(['ok','Valid JSON-LD with '+ok.length+' question'+(ok.length>1?'s':'')+'. Make sure the same questions and answers are visible on your page.']);}
    msgs.innerHTML=''; m.forEach(function(x){var li=document.createElement('li'); li.className=x[0]==='ok'?'pah-fg-ok':'pah-fg-warn'; li.textContent=(x[0]==='ok'?'✔ ':'⚠ ')+x[1]; msgs.appendChild(li);});
    stats.textContent=ok.length+' complete question'+(ok.length===1?'':'s')+' · '+out.textContent.length+' characters';
    copied.textContent='';
  }
  document.getElementById('pah-fg-add').addEventListener('click',function(){addRow(); var q=rows.lastChild.querySelector('.pah-fg-q'); q.focus();});
  document.getElementById('pah-fg-clear').addEventListener('click',function(){rows.innerHTML=''; addRow();});
  document.getElementById('pah-fg-sample').addEventListener('click',function(){
    rows.innerHTML='';
    addRow('What is FAQ schema?','FAQ schema is structured data in JSON-LD format that marks up a list of questions and answers on a page, so search engines and AI tools can understand them clearly.');
    addRow('Where should I add the FAQ schema code?','Paste the code into the HTML of the same page that shows these questions and answers, for example in a Custom HTML block in WordPress or through your SEO plugin.');
  });
  wrap.addEventListener('change',render); pretty.addEventListener('change',render);
  document.getElementById('pah-fg-copy').addEventListener('click',function(){
    var t=out.textContent; if(!items().some(function(x){return x.q&&x.a;})){copied.textContent='Nothing to copy yet.';return;}
    function done(){copied.textContent='Copied!';}
    if(navigator.clipboard&&window.isSecureContext){navigator.clipboard.writeText(t).then(done,fallback);}else{fallback();}
    function fallback(){var ta=document.createElement('textarea');ta.value=t;ta.setAttribute('readonly','');ta.style.position='absolute';ta.style.left='-9999px';document.body.appendChild(ta);ta.select();try{document.execCommand('copy');done();}catch(e){copied.textContent='Select the code and copy it manually.';}document.body.removeChild(ta);}
  });
  addRow(); addRow();
})();
</script>
PAHHTML;
    return $html;
}
add_shortcode( 'pah_faq_schema_generator', 'pah_faq_schema_generator_shortcode' );
