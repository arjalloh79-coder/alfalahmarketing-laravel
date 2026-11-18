@extends('User.main')

@section('title', app()->getLocale() === 'fr' ? 'Diagnostic Marketing Gratuit' : 'Free Marketing Readiness Scorecard')
@section('description', app()->getLocale() === 'fr'
    ? 'Évaluez votre marketing en 2 minutes et recevez un plan d’action personnalisé — gratuit, bilingue, par Al-Falah Marketing.'
    : 'Score your marketing in 2 minutes and get a personalized action plan — free, bilingual, by Al-Falah Marketing.')

@section('styles')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&display=swap">
<style>
/* ===== Al-Falah Scorecard — all rules scoped under .afsc to protect site styles ===== */
.afsc{--bg:#f6f4ee;--surface:#fff;--fg:#1b2420;--muted:#5d6b63;--line:#e4e0d6;
  --brand:#0f5132;--brand-soft:#e7efe9;--gold:#b8860b;--gold-soft:#f6edd6;
  --good:#2e7d4f;--warn:#c77d1a;--crit:#c0392b;
  --shadow:0 1px 2px rgba(27,36,32,.06),0 8px 24px rgba(27,36,32,.08);--r:16px;
  background:var(--bg);color:var(--fg);font-family:Outfit,system-ui,sans-serif;line-height:1.5;
  padding:96px 0 64px;-webkit-font-smoothing:antialiased}
.afsc .wrap{max-width:720px;margin:0 auto;padding:0 16px}
.afsc h1,.afsc h2,.afsc h3{font-family:"Space Grotesk",Outfit,sans-serif;margin:0;letter-spacing:-.01em;color:var(--fg)}
.afsc p{margin:0}
.afsc button{font-family:inherit;cursor:pointer}
.afsc .eyebrow{font-size:12px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--gold)}
.afsc .muted{color:var(--muted)}
.afsc .topbar{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:22px}
.afsc .brand{display:flex;align-items:center;gap:10px;min-width:0}
.afsc .mark{width:34px;height:34px;border-radius:9px;background:var(--brand);color:#fff;display:grid;place-items:center;font-family:"Space Grotesk";font-weight:700;font-size:15px;flex:none}
.afsc .brand b{font-family:"Space Grotesk";font-weight:700;font-size:15px;white-space:nowrap}
.afsc .brand span{font-size:11px;color:var(--muted);display:block;margin-top:-2px}
.afsc .controls{display:flex;gap:6px;flex:none}
.afsc .pill{border:1px solid var(--line);background:var(--surface);color:var(--muted);border-radius:999px;padding:6px 11px;font-size:12px;font-weight:600;line-height:1}
.afsc .pill[aria-pressed="true"]{background:var(--brand);border-color:var(--brand);color:#fff}
.afsc .pill.ghost{color:var(--fg)}
.afsc .card{background:var(--surface);border:1px solid var(--line);border-radius:var(--r);box-shadow:var(--shadow)}
.afsc .pad{padding:26px}@media(max-width:460px){.afsc .pad{padding:20px}}
.afsc .btn{border:none;border-radius:12px;padding:14px 22px;font-size:15px;font-weight:600;background:var(--brand);color:#fff;box-shadow:var(--shadow);transition:filter .15s}
.afsc .btn:hover{filter:brightness(1.06)}
.afsc .btn.gold{background:var(--gold);color:#241c00}
.afsc .btn.outline{background:transparent;color:var(--fg);border:1px solid var(--line);box-shadow:none}
.afsc .btn:disabled{opacity:.45;cursor:not-allowed}
.afsc a.btn{text-decoration:none;display:inline-flex;align-items:center;gap:8px;justify-content:center}
.afsc .btn-row{display:flex;gap:10px;flex-wrap:wrap}
.afsc .hero h1{font-size:clamp(28px,6.5vw,40px);line-height:1.08;margin:14px 0 12px}
.afsc .hero .lead{font-size:16px;color:var(--muted);max-width:56ch}
.afsc .trust{display:flex;flex-wrap:wrap;gap:8px;margin-top:20px}
.afsc .chip{font-size:12.5px;font-weight:500;background:var(--brand-soft);color:var(--brand);border-radius:999px;padding:6px 12px}
.afsc .meta{display:flex;gap:18px;flex-wrap:wrap;margin-top:22px;color:var(--muted);font-size:13px}
.afsc .meta b{color:var(--fg)}
.afsc .prog{height:6px;background:var(--line);border-radius:999px;overflow:hidden;margin-bottom:6px}
.afsc .prog>i{display:block;height:100%;background:var(--gold);border-radius:999px;transition:width .3s ease}
.afsc .qcount{font-size:12px;color:var(--muted);font-weight:600}
.afsc .q h2{font-size:clamp(20px,4.6vw,26px);line-height:1.2;margin:10px 0 4px}
.afsc .q .area{font-size:12px;font-weight:600;color:var(--gold);letter-spacing:.06em;text-transform:uppercase}
.afsc .opts{display:flex;flex-direction:column;gap:10px;margin:20px 0 4px}
.afsc .opt{display:flex;align-items:flex-start;gap:12px;text-align:left;width:100%;border:1.5px solid var(--line);background:var(--surface);border-radius:12px;padding:14px 16px;font-size:14.5px;color:var(--fg);transition:border-color .12s,background .12s}
.afsc .opt:hover{border-color:var(--brand)}
.afsc .opt[aria-pressed="true"]{border-color:var(--brand);background:var(--brand-soft)}
.afsc .dot{width:20px;height:20px;border-radius:999px;border:2px solid var(--line);flex:none;margin-top:1px;position:relative}
.afsc .opt[aria-pressed="true"] .dot{border-color:var(--brand)}
.afsc .opt[aria-pressed="true"] .dot::after{content:"";position:absolute;inset:3px;border-radius:999px;background:var(--brand)}
.afsc .navrow{display:flex;justify-content:space-between;gap:10px;margin-top:22px}
.afsc .scorehead{display:flex;align-items:center;gap:22px;flex-wrap:wrap}
.afsc .ring{position:relative;width:132px;height:132px;flex:none}
.afsc .ring svg{transform:rotate(-90deg)}
.afsc .ring .num{position:absolute;inset:0;display:grid;place-content:center;text-align:center}
.afsc .ring .num b{font-family:"Space Grotesk";font-size:34px;font-weight:700;line-height:1}
.afsc .ring .num span{font-size:12px;color:var(--muted)}
.afsc .tierbox{min-width:0;flex:1}
.afsc .tierbox h2{font-size:clamp(22px,5vw,28px);margin:2px 0 6px}
.afsc .tag{display:inline-block;font-size:12px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;padding:5px 11px;border-radius:999px;color:#fff}
.afsc .bars{display:flex;flex-direction:column;gap:14px;margin-top:8px}
.afsc .bar .top{display:flex;justify-content:space-between;align-items:baseline;gap:10px;margin-bottom:5px}
.afsc .bar .top b{font-size:14px;font-weight:600}
.afsc .bar .top span{font-size:12px;font-weight:600;font-variant-numeric:tabular-nums}
.afsc .track{height:9px;background:var(--line);border-radius:999px;overflow:hidden}
.afsc .track>i{display:block;height:100%;border-radius:999px;transition:width .5s ease}
.afsc .rec{margin-top:7px;font-size:13px;color:var(--muted);line-height:1.5}
.afsc .rec b{color:var(--fg);font-weight:600}
.afsc .sectitle{display:flex;align-items:center;gap:10px;margin:0 0 14px}
.afsc .sectitle h3{font-size:16px}.afsc .sectitle .ln{flex:1;height:1px;background:var(--line)}
.afsc label.fld{display:block;margin-bottom:16px}
.afsc label.fld>span{display:block;font-size:13px;font-weight:600;margin-bottom:6px}
.afsc .req{color:var(--crit)}
.afsc input,.afsc select,.afsc textarea{width:100%;font-family:inherit;font-size:15px;color:var(--fg);background:var(--surface);border:1.5px solid var(--line);border-radius:10px;padding:12px 13px}
.afsc textarea{min-height:76px;resize:vertical}
.afsc .grid2{display:grid;grid-template-columns:1fr 1fr;gap:0 14px}@media(max-width:460px){.afsc .grid2{grid-template-columns:1fr}}
.afsc .summary{background:var(--bg);border:1px dashed var(--line);border-radius:12px;padding:16px;font-size:13.5px;white-space:pre-wrap;line-height:1.6;font-family:ui-monospace,Menlo,monospace}
.afsc .steps{counter-reset:s;display:flex;flex-direction:column;gap:12px;margin-top:6px}
.afsc .step{display:flex;gap:12px;align-items:flex-start}
.afsc .step::before{counter-increment:s;content:counter(s);flex:none;width:26px;height:26px;border-radius:999px;background:var(--brand);color:#fff;display:grid;place-items:center;font-size:13px;font-weight:700;font-family:"Space Grotesk"}
.afsc .contactline{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-top:4px;font-size:14px}
.afsc .copybtn{border:1px solid var(--line);background:var(--surface);border-radius:8px;padding:5px 10px;font-size:12px;font-weight:600;color:var(--fg)}
.afsc code.addr{font-family:ui-monospace,Menlo,monospace;background:var(--brand-soft);color:var(--brand);padding:3px 8px;border-radius:7px;font-size:13px;user-select:all}
.afsc .foot{text-align:center;margin-top:26px;font-size:12px;color:var(--muted)}
.afsc .afhide{display:none!important}
</style>
@endsection

@section('main-section')
@php $loc = app()->getLocale(); @endphp
<div id="afScorecard" class="afsc" data-loc="{{ $loc }}" data-wa="12402806137" data-email="info@al-falahmarketing.com">
  <div class="wrap">
    <div class="topbar">
      <div class="brand"><div class="mark">AF</div><div><b>Al-Falah Marketing</b><span data-i="tagline">Digital growth partner</span></div></div>
      <div class="controls">
        <button class="pill" data-lang="en" aria-pressed="true">EN</button>
        <button class="pill" data-lang="fr" aria-pressed="false">FR</button>
      </div>
    </div>

    <section data-screen="intro" class="card pad hero">
      <div class="eyebrow" data-i="introEyebrow"></div>
      <h1 data-i="introTitle"></h1>
      <p class="lead" data-i="introLead"></p>
      <div class="trust">
        <span class="chip" data-i="c1"></span><span class="chip" data-i="c2"></span>
        <span class="chip" data-i="c3"></span><span class="chip" data-i="c4"></span><span class="chip" data-i="c5"></span>
      </div>
      <div class="meta">
        <span>⏱️ <b data-i="m1"></b></span><span>🔒 <b data-i="m2"></b></span><span>📊 <b data-i="m3"></b></span>
      </div>
      <div style="margin-top:26px"><button class="btn" data-act="start" data-i="startBtn"></button></div>
    </section>

    <section data-screen="quiz" class="afhide">
      <div class="prog"><i data-el="progbar" style="width:0%"></i></div>
      <div class="qcount" data-el="qcount">1 / 7</div>
      <div class="card pad q" style="margin-top:14px">
        <div class="area" data-el="qarea"></div>
        <h2 data-el="qtext"></h2>
        <div class="opts" data-el="opts"></div>
        <div class="navrow">
          <button class="btn outline" data-act="back" data-i="back"></button>
          <button class="btn" data-act="next" disabled data-i="next"></button>
        </div>
      </div>
    </section>

    <section data-screen="results" class="afhide">
      <div class="card pad">
        <div class="eyebrow" data-i="resEyebrow"></div>
        <div class="scorehead" style="margin-top:14px">
          <div class="ring">
            <svg width="132" height="132" viewBox="0 0 132 132">
              <circle cx="66" cy="66" r="58" fill="none" stroke="var(--line)" stroke-width="12"/>
              <circle data-el="ringfill" cx="66" cy="66" r="58" fill="none" stroke="var(--gold)" stroke-width="12" stroke-linecap="round" stroke-dasharray="364" stroke-dashoffset="364"/>
            </svg>
            <div class="num"><b data-el="scoreNum">0</b><span>/ 21</span></div>
          </div>
          <div class="tierbox">
            <span class="tag" data-el="tierTag"></span>
            <h2 data-el="tierTitle"></h2>
            <p class="muted" data-el="tierDesc" style="font-size:14px"></p>
          </div>
        </div>
      </div>
      <div class="card pad" style="margin-top:14px">
        <div class="sectitle"><h3 data-i="breakdownTitle"></h3><div class="ln"></div></div>
        <div class="bars" data-el="bars"></div>
      </div>
      <div class="card pad" style="margin-top:14px;background:var(--brand);border-color:var(--brand);color:#fff">
        <h2 style="font-size:22px;color:#fff" data-i="ctaTitle"></h2>
        <p style="margin:8px 0 18px;opacity:.92;font-size:15px" data-i="ctaLead"></p>
        <button class="btn gold" data-act="toLead" data-i="ctaBtn"></button>
      </div>
      <div class="foot"><button class="pill ghost" data-act="restart" data-i="restart"></button></div>
    </section>

    <section data-screen="lead" class="afhide">
      <div class="card pad">
        <div class="eyebrow" data-i="leadEyebrow"></div>
        <h2 style="font-size:24px;margin:12px 0 6px" data-i="leadTitle"></h2>
        <p class="muted" style="font-size:14px;margin-bottom:22px" data-i="leadLead"></p>
        <form data-el="leadForm" novalidate>
          <div class="grid2">
            <label class="fld"><span data-i="fName"></span> <input data-f="name" autocomplete="name" required></label>
            <label class="fld"><span data-i="fBiz"></span><input data-f="biz" autocomplete="organization"></label>
          </div>
          <label class="fld"><span data-i="fType"></span><input data-f="sector" required></label>
          <label class="fld"><span data-i="fChallenge"></span><select data-f="challenge" required></select></label>
          <label class="fld"><span data-i="fService"></span><select data-f="service"></select></label>
          <label class="fld"><span data-i="fGoal"></span><textarea data-f="goal"></textarea></label>
          <div class="grid2">
            <label class="fld"><span data-i="fBudget"></span><select data-f="budget"></select></label>
            <label class="fld"><span data-i="fTimeline"></span><select data-f="timeline"></select></label>
          </div>
          <div class="grid2">
            <label class="fld"><span data-i="fContactName"></span><input data-f="contact" inputmode="tel" required></label>
            <label class="fld"><span data-i="fEmail"></span><input data-f="email" type="email" autocomplete="email"></label>
          </div>
          <div class="navrow" style="margin-top:4px">
            <button type="button" class="btn outline" data-act="leadBack" data-i="back"></button>
            <button type="submit" class="btn gold" data-i="leadSubmit"></button>
          </div>
        </form>
      </div>
    </section>

    <section data-screen="done" class="afhide">
      <div class="card pad" style="text-align:center">
        <div style="font-size:46px">✅</div>
        <h2 style="font-size:26px;margin:8px 0 6px" data-i="doneTitle"></h2>
        <p class="muted" style="font-size:15px" data-i="doneLead"></p>
      </div>
      <div class="card pad" style="margin-top:14px">
        <div class="sectitle"><h3 data-i="sumTitle"></h3><div class="ln"></div></div>
        <div class="summary" data-el="sumText"></div>
        <div class="btn-row" style="margin-top:16px">
          <a class="btn gold" data-el="waBtn" target="_blank" rel="noopener" data-i="waBtn"></a>
          <button class="btn outline" data-act="copySum" data-i="copySum"></button>
        </div>
        <div class="contactline">
          <span class="muted" data-i="orReach"></span>
          <code class="addr" data-el="emailAddr"></code>
          <button class="copybtn" data-act="copyEmail" data-i="copy"></button>
        </div>
      </div>
      <div class="card pad" style="margin-top:14px">
        <div class="sectitle"><h3 data-i="nextTitle"></h3><div class="ln"></div></div>
        <div class="steps">
          <div class="step"><div><b data-i="s1t"></b><br><span class="muted" style="font-size:13.5px" data-i="s1d"></span></div></div>
          <div class="step"><div><b data-i="s2t"></b><br><span class="muted" style="font-size:13.5px" data-i="s2d"></span></div></div>
          <div class="step"><div><b data-i="s3t"></b><br><span class="muted" style="font-size:13.5px" data-i="s3d"></span></div></div>
        </div>
      </div>
      <div class="foot"><button class="pill ghost" data-act="restart" data-i="restart"></button></div>
    </section>
  </div>
</div>
@endsection

@section('scripts')
<script>
(function(){
  var ROOT=document.getElementById('afScorecard'); if(!ROOT) return;
  var CONFIG={whatsapp:ROOT.dataset.wa,email:ROOT.dataset.email};
  var $=function(s){return ROOT.querySelector(s)}, $$=function(s){return ROOT.querySelectorAll(s)};

  var T={
    en:{tagline:"Digital growth partner",introEyebrow:"Free · 2-minute check",introTitle:"Is your business marketing ready to grow?",
      introLead:"Answer 7 quick questions about your online presence. You'll get an instant score and a personalized action plan built around what your business actually needs next.",
      c1:"🎯 Strategy",c2:"🌐 Website",c3:"🔍 SEO",c4:"✍️ Content",c5:"📥 Leads",
      m1:"~2 minutes",m2:"No account needed",m3:"Instant results",startBtn:"Start my scorecard →",back:"← Back",next:"Next →",
      resEyebrow:"Your result",breakdownTitle:"Where you stand, area by area",ctaTitle:"Want this turned into a done-for-you plan?",
      ctaLead:"Al-Falah Marketing can build and run the pieces you're missing — strategy, website, SEO, content and lead generation. Tell us about your business and we'll send tailored next steps.",
      ctaBtn:"Get my tailored plan →",restart:"↺ Start over",
      leadEyebrow:"Last step",leadTitle:"Tell us where to send your plan",leadLead:"Takes 30 seconds. We use this to prepare relevant advice — no spam.",
      fName:"Your name *",fBiz:"Business name",fType:"What type of business do you run? *",fChallenge:"Your biggest marketing challenge right now *",
      fService:"Which service are you most interested in?",fGoal:"What result are you hoping to achieve?",fBudget:"Approx. monthly budget",fTimeline:"Timeline",
      fContactName:"Best contact (WhatsApp / phone) *",fEmail:"Email (optional)",leadSubmit:"See my plan & contact →",
      doneTitle:"Your plan summary is ready",doneLead:"Send it to Al-Falah Marketing in one tap, or copy it. We reply within one business day.",
      sumTitle:"Your enquiry",waBtn:"Send on WhatsApp",copySum:"Copy summary",orReach:"Or reach us directly:",copy:"Copy",nextTitle:"What happens next",
      s1t:"We review your answers",s1d:"A real strategist looks at your score and challenge.",
      s2t:"You get tailored next steps",s2d:"Clear, prioritized recommendations for your budget.",
      s3t:"We grow it together",s3d:"Pick the services that fit. Start small, scale what works.",
      goalPH:"e.g. more enquiries, more online sales, better visibility…",copied:"Copied ✓",
      challenges:["Not enough customers / enquiries","Low visibility — people can't find us","Posting a lot but no results","Website isn't working","No clear strategy","Not sure what's wrong"],
      services:["Not sure yet — need advice","Social media management","Website design","SEO / Google visibility","Content creation","Lead generation","Full-service digital marketing"],
      budgets:["Under $300 / mo","$300 – $800 / mo","$800 – $2,000 / mo","$2,000+ / mo","Prefer to discuss"],
      timelines:["As soon as possible","Within 1 month","1–3 months","Just exploring"],
      tiers:[{min:0,tag:"Needs attention",title:"Your foundations are at risk",desc:"Several basics are missing. The good news: these are the fastest, cheapest things to fix — and fixing them usually lifts everything else.",color:"var(--crit)"},
        {min:9,tag:"Building",title:"You're building momentum",desc:"You've got real pieces in place, but they aren't yet working as one system. A few focused upgrades will start turning attention into enquiries.",color:"var(--warn)"},
        {min:15,tag:"Growth-ready",title:"You're growth-ready",desc:"Strong foundations. Now it's about connecting your channels and tightening how you capture and convert leads.",color:"var(--good)"},
        {min:19,tag:"Scaling",title:"You're ready to scale",desc:"Impressive. Your marketing works as a system — the opportunity now is to amplify what already converts and measure ROI closely.",color:"var(--good)"}],
      L:{title:"AL-FALAH MARKETING — New enquiry from Scorecard",score:"Score",tier:"Tier",name:"Name",biz:"Business",sector:"Business type",challenge:"Main challenge",service:"Service interest",goal:"Goal",budget:"Budget",timeline:"Timeline",contact:"Contact",email:"Email",weak:"Weakest areas"}},
    fr:{tagline:"Partenaire de croissance digitale",introEyebrow:"Gratuit · test de 2 minutes",introTitle:"Votre marketing est-il prêt pour la croissance ?",
      introLead:"Répondez à 7 questions rapides sur votre présence en ligne. Vous obtiendrez un score instantané et un plan d'action personnalisé, adapté aux besoins réels de votre entreprise.",
      c1:"🎯 Stratégie",c2:"🌐 Site web",c3:"🔍 SEO",c4:"✍️ Contenu",c5:"📥 Prospects",
      m1:"~2 minutes",m2:"Sans inscription",m3:"Résultats instantanés",startBtn:"Lancer mon diagnostic →",back:"← Retour",next:"Suivant →",
      resEyebrow:"Votre résultat",breakdownTitle:"Votre situation, domaine par domaine",ctaTitle:"Envie d'un plan clé en main ?",
      ctaLead:"Al-Falah Marketing peut construire et gérer ce qui vous manque — stratégie, site web, SEO, contenu et génération de prospects. Parlez-nous de votre entreprise et recevez des recommandations sur mesure.",
      ctaBtn:"Obtenir mon plan sur mesure →",restart:"↺ Recommencer",
      leadEyebrow:"Dernière étape",leadTitle:"Où devons-nous envoyer votre plan ?",leadLead:"30 secondes. Ces infos nous servent à préparer des conseils pertinents — pas de spam.",
      fName:"Votre nom *",fBiz:"Nom de l'entreprise",fType:"Quel type d'entreprise gérez-vous ? *",fChallenge:"Votre plus grand défi marketing actuel *",
      fService:"Quel service vous intéresse le plus ?",fGoal:"Quel résultat souhaitez-vous atteindre ?",fBudget:"Budget mensuel approximatif",fTimeline:"Échéance",
      fContactName:"Meilleur contact (WhatsApp / tél.) *",fEmail:"E-mail (facultatif)",leadSubmit:"Voir mon plan & contacter →",
      doneTitle:"Votre résumé de plan est prêt",doneLead:"Envoyez-le à Al-Falah Marketing en un clic, ou copiez-le. Nous répondons sous un jour ouvré.",
      sumTitle:"Votre demande",waBtn:"Envoyer sur WhatsApp",copySum:"Copier le résumé",orReach:"Ou contactez-nous directement :",copy:"Copier",nextTitle:"La suite",
      s1t:"Nous analysons vos réponses",s1d:"Un vrai stratège examine votre score et votre défi.",
      s2t:"Vous recevez des étapes sur mesure",s2d:"Des recommandations claires et prioritaires selon votre budget.",
      s3t:"Nous développons ensemble",s3d:"Choisissez les services adaptés. Commencez petit, amplifiez ce qui marche.",
      goalPH:"ex. plus de demandes, plus de ventes en ligne, meilleure visibilité…",copied:"Copié ✓",
      challenges:["Pas assez de clients / demandes","Peu de visibilité — on ne nous trouve pas","Je publie beaucoup sans résultats","Mon site ne fonctionne pas","Aucune stratégie claire","Je ne sais pas ce qui cloche"],
      services:["Pas encore sûr — besoin de conseils","Gestion des réseaux sociaux","Création de site web","SEO / visibilité Google","Création de contenu","Génération de prospects","Marketing digital complet"],
      budgets:["Moins de 300 $/mois","300 – 800 $/mois","800 – 2 000 $/mois","2 000 $+/mois","Je préfère en discuter"],
      timelines:["Dès que possible","Sous 1 mois","1–3 mois","Je me renseigne"],
      tiers:[{min:0,tag:"À renforcer",title:"Vos fondations sont fragiles",desc:"Plusieurs bases manquent. La bonne nouvelle : ce sont les éléments les plus rapides et économiques à corriger — et les corriger fait souvent progresser tout le reste.",color:"var(--crit)"},
        {min:9,tag:"En construction",title:"Vous prenez de l'élan",desc:"Vous avez de vrais atouts, mais ils ne fonctionnent pas encore comme un système. Quelques améliorations ciblées commenceront à transformer l'attention en demandes.",color:"var(--warn)"},
        {min:15,tag:"Prêt à croître",title:"Vous êtes prêt pour la croissance",desc:"Fondations solides. L'enjeu maintenant : connecter vos canaux et renforcer la captation et la conversion des prospects.",color:"var(--good)"},
        {min:19,tag:"Accélération",title:"Vous êtes prêt à passer à l'échelle",desc:"Impressionnant. Votre marketing fonctionne comme un système — l'opportunité est d'amplifier ce qui convertit déjà et de mesurer le ROI de près.",color:"var(--good)"}],
      L:{title:"AL-FALAH MARKETING — Nouvelle demande (diagnostic)",score:"Score",tier:"Niveau",name:"Nom",biz:"Entreprise",sector:"Type d'entreprise",challenge:"Défi principal",service:"Service souhaité",goal:"Objectif",budget:"Budget",timeline:"Échéance",contact:"Contact",email:"E-mail",weak:"Domaines les plus faibles"}}
  };

  var Q=[
    {area:{en:"Target audience",fr:"Audience cible"},q:{en:"How clearly do you know your ideal customer?",fr:"À quel point connaissez-vous votre client idéal ?"},
     opts:[{en:"We market to everyone",fr:"On s'adresse à tout le monde",p:0},{en:"A rough idea",fr:"Une idée approximative",p:1},{en:"A clear profile",fr:"Un profil clair",p:2},{en:"Detailed profile we build content around",fr:"Profil détaillé qui guide notre contenu",p:3}],
     rec:{low:{en:"Define one ideal-customer profile — their problems, budget and buying habits — before creating more content. Our <b>strategy</b> service starts here.",fr:"Définissez un profil de client idéal — ses problèmes, son budget, ses habitudes d'achat — avant de produire plus de contenu. Notre service <b>stratégie</b> commence ici."},ok:{en:"You have a target — sharpen it into a written profile so every post speaks to one person.",fr:"Vous avez une cible — précisez-la en un profil écrit pour que chaque publication parle à une seule personne."},strong:{en:"Strong targeting. Keep validating it with the enquiries you actually receive.",fr:"Ciblage solide. Continuez à le valider avec les demandes que vous recevez réellement."}}},
    {area:{en:"Website",fr:"Site web"},q:{en:"When someone lands on your website, how fast do they understand what you do and how to contact you?",fr:"Quand un visiteur arrive sur votre site, comprend-il vite ce que vous faites et comment vous contacter ?"},
     opts:[{en:"We don't really have a website",fr:"On n'a pas vraiment de site",p:0},{en:"It's there but confusing / slow",fr:"Il existe mais confus / lent",p:1},{en:"Clear, but contact isn't obvious",fr:"Clair, mais le contact n'est pas évident",p:2},{en:"Clear message + easy, visible contact",fr:"Message clair + contact facile et visible",p:3}],
     rec:{low:{en:"Your website is often the first impression. A clear message and an obvious way to contact you can lift enquiries immediately — our <b>website design</b> service fixes this.",fr:"Le site est souvent la première impression. Un message clair et un contact évident peuvent augmenter les demandes immédiatement — notre service <b>création de site</b> règle cela."},ok:{en:"Make your call-to-action and contact option impossible to miss on every page.",fr:"Rendez votre appel à l'action et votre contact impossibles à manquer sur chaque page."},strong:{en:"Your site does its job. Check it stays fast and clear on mobile.",fr:"Votre site fait le travail. Vérifiez qu'il reste rapide et clair sur mobile."}}},
    {area:{en:"Content consistency",fr:"Régularité du contenu"},q:{en:"How consistent and purposeful is the content you publish?",fr:"Votre contenu est-il régulier et a-t-il un objectif ?"},
     opts:[{en:"We rarely post",fr:"On publie rarement",p:0},{en:"We post randomly, no plan",fr:"On publie au hasard, sans plan",p:1},{en:"Regular, but mostly promotion",fr:"Régulier, mais surtout promotionnel",p:2},{en:"Planned mix: educate, build trust, convert",fr:"Mix planifié : informer, rassurer, convertir",p:3}],
     rec:{low:{en:"Posting randomly rarely generates enquiries. A simple content calendar mixing education, trust and conversion changes that — our <b>content</b> + <b>social media</b> services.",fr:"Publier au hasard génère rarement des demandes. Un calendrier simple mêlant information, confiance et conversion change la donne — nos services <b>contenu</b> + <b>réseaux sociaux</b>."},ok:{en:"Balance your mix: too much promotion tires your audience. Add educational and trust-building posts.",fr:"Équilibrez votre mix : trop de promotion fatigue l'audience. Ajoutez du contenu éducatif et de confiance."},strong:{en:"Great rhythm. Repurpose your best posts into other formats to do more with less.",fr:"Excellent rythme. Recyclez vos meilleurs contenus en d'autres formats pour faire plus avec moins."}}},
    {area:{en:"Search visibility (SEO)",fr:"Visibilité (SEO)"},q:{en:"If a customer searches Google for your service, can they find you?",fr:"Si un client cherche votre service sur Google, vous trouve-t-il ?"},
     opts:[{en:"No idea / probably not",fr:"Aucune idée / sans doute pas",p:0},{en:"Only if they search our name",fr:"Seulement avec notre nom",p:1},{en:"Sometimes, for a few terms",fr:"Parfois, pour quelques termes",p:2},{en:"Yes — we rank + Google Business set up",fr:"Oui — on ressort + fiche Google en place",p:3}],
     rec:{low:{en:"Customers who search are ready to buy. Basic SEO and a complete Google Business Profile help them find you — our <b>SEO</b> service.",fr:"Les clients qui cherchent sont prêts à acheter. Un SEO de base et une fiche Google complète les aident à vous trouver — notre service <b>SEO</b>."},ok:{en:"Build on it: target the exact phrases customers search and keep your Google profile and reviews fresh.",fr:"Allez plus loin : ciblez les expressions exactes recherchées et gardez votre fiche Google et vos avis à jour."},strong:{en:"Good visibility. Track which search terms actually bring enquiries, not just traffic.",fr:"Bonne visibilité. Suivez les termes qui apportent des demandes, pas seulement du trafic."}}},
    {area:{en:"Lead capture & CTA",fr:"Captation & appel à l'action"},q:{en:"Do your posts and pages tell people exactly what to do next — and capture their details?",fr:"Vos publications et pages disent-elles exactement quoi faire — et captent-elles les coordonnées ?"},
     opts:[{en:"No clear next step anywhere",fr:"Aucune étape suivante claire",p:0},{en:"Sometimes we add a CTA",fr:"Parfois on ajoute un appel à l'action",p:1},{en:"Clear CTA, but no way to capture leads",fr:"CTA clair, mais pas de captation",p:2},{en:"Clear CTA + a real way to capture & follow up",fr:"CTA clair + captation et relance en place",p:3}],
     rec:{low:{en:"Attention without a next step is wasted. Every post needs one clear call-to-action pointing to a monitored channel — the core of our <b>lead generation</b> service.",fr:"L'attention sans étape suivante est perdue. Chaque publication a besoin d'un appel à l'action clair vers un canal surveillé — le cœur de notre service <b>génération de prospects</b>."},ok:{en:"Add a simple way to capture leads (form, DM keyword, WhatsApp) and a follow-up habit.",fr:"Ajoutez un moyen simple de capter les prospects (formulaire, mot-clé en DM, WhatsApp) et une relance régulière."},strong:{en:"Solid funnel. Test different CTAs to see which attracts the best-fit leads.",fr:"Tunnel solide. Testez différents CTA pour voir lequel attire les prospects les plus pertinents."}}},
    {area:{en:"Measurement",fr:"Mesure"},q:{en:"Do you track what your marketing actually produces?",fr:"Mesurez-vous ce que votre marketing produit réellement ?"},
     opts:[{en:"We don't track anything",fr:"On ne suit rien",p:0},{en:"We watch likes & views only",fr:"On regarde seulement likes & vues",p:1},{en:"We track traffic & enquiries",fr:"On suit trafic & demandes",p:2},{en:"We track enquiries, cost per lead & sales",fr:"On suit demandes, coût par prospect & ventes",p:3}],
     rec:{low:{en:"Without numbers you're guessing. Start tracking enquiries, website clicks and sales so you invest in what works — part of our <b>strategy</b> service.",fr:"Sans chiffres, vous devinez. Suivez les demandes, les clics et les ventes pour investir dans ce qui marche — inclus dans notre service <b>stratégie</b>."},ok:{en:"You're watching the right direction — add cost-per-lead and lead-to-sale rate to see true ROI.",fr:"Vous regardez dans la bonne direction — ajoutez le coût par prospect et le taux de conversion pour voir le vrai ROI."},strong:{en:"Data-driven. Use it to double down on your highest-ROI channels each month.",fr:"Piloté par les données. Utilisez-les pour renforcer vos canaux les plus rentables chaque mois."}}},
    {area:{en:"Brand consistency",fr:"Cohérence de marque"},q:{en:"Does your business look consistent and professional across every platform?",fr:"Votre entreprise paraît-elle cohérente et professionnelle partout ?"},
     opts:[{en:"Different look everywhere",fr:"Une image différente partout",p:0},{en:"Same name, inconsistent visuals",fr:"Même nom, visuels incohérents",p:1},{en:"Mostly consistent",fr:"Plutôt cohérent",p:2},{en:"Consistent logo, colors, voice everywhere",fr:"Logo, couleurs, ton cohérents partout",p:3}],
     rec:{low:{en:"Inconsistent branding makes you look smaller than you are. Consistent colors, logo and voice build instant recognition — our <b>content</b> + <b>branding</b> work.",fr:"Une image incohérente vous fait paraître plus petit. Des couleurs, un logo et un ton cohérents créent une reconnaissance immédiate — nos services <b>contenu</b> + <b>branding</b>."},ok:{en:"Tighten it: one color set, one logo, one voice across every profile and your website.",fr:"Resserrez : un jeu de couleurs, un logo, un ton sur chaque profil et votre site."},strong:{en:"Recognizable brand. Keep a simple brand sheet so it stays consistent as you grow.",fr:"Marque reconnaissable. Gardez une fiche de marque simple pour rester cohérent en grandissant."}}}
  ];

  var lang=(ROOT.dataset.loc==='fr')?'fr':'en', step=0, answers=new Array(Q.length).fill(null);

  function show(name){$$('[data-screen]').forEach(function(s){s.classList.toggle('afhide',s.dataset.screen!==name)});window.scrollTo({top:ROOT.offsetTop-20,behavior:'smooth'})}
  function fillSelect(el,arr){var cur=el.selectedIndex;el.innerHTML=arr.map(function(o,i){return '<option value="'+i+'">'+o+'</option>'}).join('');if(cur>0)el.selectedIndex=cur}
  function applyStatic(){
    var t=T[lang];
    $$('[data-i]').forEach(function(el){if(t[el.dataset.i]!==undefined)el.innerHTML=t[el.dataset.i]});
    $$('[data-lang]').forEach(function(b){b.setAttribute('aria-pressed',b.dataset.lang===lang)});
    $('[data-f="goal"]').placeholder=t.goalPH;
    fillSelect($('[data-f="challenge"]'),t.challenges);fillSelect($('[data-f="service"]'),t.services);
    fillSelect($('[data-f="budget"]'),t.budgets);fillSelect($('[data-f="timeline"]'),t.timelines);
  }
  function renderQ(){
    var t=T[lang],item=Q[step];
    $('[data-el="qcount"]').textContent=(step+1)+' / '+Q.length;
    $('[data-el="progbar"]').style.width=(step/Q.length)*100+'%';
    $('[data-el="qarea"]').textContent=item.area[lang];
    $('[data-el="qtext"]').textContent=item.q[lang];
    $('[data-el="opts"]').innerHTML=item.opts.map(function(o,i){return '<button class="opt" data-opt="'+i+'" aria-pressed="'+(answers[step]===i)+'"><span class="dot"></span><span>'+o[lang]+'</span></button>'}).join('');
    $$('[data-el="opts"] .opt').forEach(function(b){b.onclick=function(){answers[step]=+b.dataset.opt;$$('[data-el="opts"] .opt').forEach(function(x){x.setAttribute('aria-pressed',x===b)});$('[data-act="next"]').disabled=false}});
    $('[data-act="next"]').disabled=answers[step]===null;
    $('[data-act="back"]').style.visibility=step===0?'hidden':'visible';
    $('[data-act="next"]').textContent=step===Q.length-1?(lang==='en'?'See my results →':'Voir mes résultats →'):t.next;
    applyStatic();
  }
  function totalScore(){return answers.reduce(function(s,a,i){return s+(a===null?0:Q[i].opts[a].p)},0)}
  function tierFor(sc){var ts=T[lang].tiers,r=ts[0];ts.forEach(function(x){if(sc>=x.min)r=x});return r}
  function renderResults(){
    var sc=totalScore(),tier=tierFor(sc),pct=sc/(Q.length*3),circ=2*Math.PI*58;
    $('[data-el="scoreNum"]').textContent=sc;
    var rf=$('[data-el="ringfill"]');rf.style.strokeDasharray=circ;rf.style.strokeDashoffset=circ*(1-pct);rf.style.stroke=tier.color;
    var tag=$('[data-el="tierTag"]');tag.textContent=tier.tag;tag.style.background=tier.color;
    $('[data-el="tierTitle"]').textContent=tier.title;$('[data-el="tierDesc"]').textContent=tier.desc;
    $('[data-el="bars"]').innerHTML=Q.map(function(item,i){
      var a=answers[i],p=a===null?0:item.opts[a].p,w=(p/3)*100,band=p<=1?'low':(p===2?'ok':'strong'),col=p<=1?'var(--crit)':(p===2?'var(--warn)':'var(--good)');
      return '<div class="bar"><div class="top"><b>'+item.area[lang]+'</b><span style="color:'+col+'">'+p+'/3</span></div><div class="track"><i style="width:'+w+'%;background:'+col+'"></i></div><div class="rec">'+item.rec[band][lang]+'</div></div>';
    }).join('');
    applyStatic();
  }
  function buildSummary(){
    var L=T[lang].L,sc=totalScore(),tier=tierFor(sc),t=T[lang];
    var v=function(f){return $('[data-f="'+f+'"]').value.trim()};
    var sel=function(f,arr){return arr[$('[data-f="'+f+'"]').selectedIndex]||''};
    var weak=Q.map(function(item,i){return {a:item.area[lang],p:answers[i]===null?0:item.opts[answers[i]].p}}).filter(function(x){return x.p<=1}).map(function(x){return x.a}).join(', ')||'—';
    return [L.title,"────────────────────",L.score+": "+sc+"/21  ("+tier.tag+")",L.weak+": "+weak,
      L.name+": "+v('name'),L.biz+": "+(v('biz')||'—'),L.sector+": "+v('sector'),
      L.challenge+": "+sel('challenge',t.challenges),L.service+": "+sel('service',t.services),
      L.goal+": "+(v('goal')||'—'),L.budget+": "+sel('budget',t.budgets),L.timeline+": "+sel('timeline',t.timelines),
      L.contact+": "+v('contact'),L.email+": "+(v('email')||'—')].join("\n");
  }
  function flash(b,m){var o=b.textContent;b.textContent=m;setTimeout(function(){b.textContent=o},1600)}
  function copyText(txt,b){
    if(navigator.clipboard&&navigator.clipboard.writeText){navigator.clipboard.writeText(txt).then(function(){flash(b,T[lang].copied)}).catch(function(){fallback(txt,b)})}else fallback(txt,b);
  }
  function fallback(txt,b){var ta=document.createElement('textarea');ta.value=txt;document.body.appendChild(ta);ta.select();try{document.execCommand('copy');flash(b,T[lang].copied)}catch(e){}document.body.removeChild(ta)}

  ROOT.addEventListener('click',function(e){
    var b=e.target.closest('[data-act]'); if(!b||!ROOT.contains(b))return;
    var act=b.dataset.act;
    if(act==='start'){step=0;renderQ();show('quiz')}
    else if(act==='next'){if(answers[step]===null)return;if(step<Q.length-1){step++;renderQ()}else{renderResults();show('results')}}
    else if(act==='back'){if(step>0){step--;renderQ()}}
    else if(act==='toLead'){show('lead')}
    else if(act==='leadBack'){show('results')}
    else if(act==='restart'){answers.fill(null);step=0;renderQ();show('intro')}
    else if(act==='copySum'){copyText($('[data-el="sumText"]').textContent,b)}
    else if(act==='copyEmail'){copyText(CONFIG.email,b)}
  });
  $('[data-el="leadForm"]').addEventListener('submit',function(e){
    e.preventDefault();var ok=true;
    ['name','sector','contact'].forEach(function(f){var el=$('[data-f="'+f+'"]');if(!el.value.trim()){el.style.borderColor='var(--crit)';ok=false}else el.style.borderColor=''});
    if(!ok)return;
    var sum=buildSummary();
    $('[data-el="sumText"]').textContent=sum;
    $('[data-el="emailAddr"]').textContent=CONFIG.email;
    $('[data-el="waBtn"]').href='https://wa.me/'+CONFIG.whatsapp+'?text='+encodeURIComponent(sum);
    show('done');
  });
  $$('[data-lang]').forEach(function(b){b.onclick=function(){lang=b.dataset.lang;applyStatic();var cur=ROOT.querySelector('[data-screen]:not(.afhide)');if(cur&&cur.dataset.screen==='quiz')renderQ();if(cur&&cur.dataset.screen==='results')renderResults()}});

  applyStatic();
})();
</script>
@endsection
