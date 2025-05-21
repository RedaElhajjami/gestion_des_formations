document.addEventListener('DOMContentLoaded', () => {
  // Filtres Formations
  const domaines = {
    "Management": ["Management de Projet", "Management de Services"],
    "Informatique": ["IT", "Big Data", "Réseau"]
  };
  const sujets = {
    "Management de Projet": ["Scrum", "Prince 2"],
    "Management de Services": ["ITIL", "COBIT"],
    "IT": ["JEE", "Web Technologies"],
    "Big Data": ["Hadoop", "Spark"],
    "Réseau": ["CISCO"]
  };

  const selDomaine = document.getElementById('sel-domaine');
  const selSujet   = document.getElementById('sel-sujet');
  const selCours   = document.getElementById('sel-cours');

  // Remplir domaines
  Object.keys(domaines).forEach(d => {
    const opt = new Option(d, d);
    selDomaine.add(opt);
  });

  selDomaine.addEventListener('change', () => {
    selSujet.innerHTML = '<option value="">Tous</option>';
    domaines[selDomaine.value]?.forEach(s => {
      selSujet.add(new Option(s, s));
    });
    selCours.innerHTML = '<option value="">Tous</option>';
  });

  selSujet.addEventListener('change', () => {
    selCours.innerHTML = '<option value="">Tous</option>';
    sujets[selSujet.value]?.forEach(c => {
      selCours.add(new Option(c, c));
    });
  });

});
