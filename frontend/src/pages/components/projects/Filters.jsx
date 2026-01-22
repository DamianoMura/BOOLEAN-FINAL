import React, { useState } from "react";
import { useFilters } from "../../../context/FiltersContext";

const Filters = ({ 
  isAdmin = false,
  onApplyFilters, // Callback quando si applicano filtri
  onClearFilters  // Callback quando si puliscono filtri
}) => {
  // Usa il context invece di stati locali per i dati
  const { 
    categories, 
    loadingCategories, 
    technologies, 
    loadingTechnologies,
    filters, // Filtri attuali dal context
    updateFilters // Funzione per aggiornare filtri nel context
  } = useFilters();

  // Stato locale solo per il form (non per i dati API)
  const [open, setOpen] = useState(false);
  const [localSearch, setLocalSearch] = useState(filters.search);
  const [localCategory, setLocalCategory] = useState(filters.category);
  const [localTechnology, setLocalTechnology] = useState(filters.technology);
  const [localPublished, setLocalPublished] = useState(filters.published);
  const [localSortBy, setLocalSortBy] = useState(filters.sort_by);
  const [localSortOrder, setLocalSortOrder] = useState(filters.sort_order);

  const handleSubmit = (e) => {
    e.preventDefault();
    
    // Crea oggetto con i nuovi filtri
    const newFilters = {
      search: localSearch,
      category: localCategory,
      technology: localTechnology,
      published: localPublished,
      sort_by: localSortBy,
      sort_order: localSortOrder
    };
    
    // 1. Aggiorna il context globale
    updateFilters(newFilters);
    
    // 2. Chiama la callback del parent per fare la fetch
    if (onApplyFilters) {
      onApplyFilters(newFilters);
    }
  };

  const handleClear = () => {
    // Reset valori locali
    setLocalSearch('');
    setLocalCategory('all');
    setLocalTechnology('');
    setLocalPublished('');
    setLocalSortBy('created_at');
    setLocalSortOrder('desc');
    
    // Reset context globale
    updateFilters({
      search: '',
      category: 'all',
      technology: '',
      published: '',
      sort_by: 'created_at',
      sort_order: 'desc'
    });
    
    // Chiama callback del parent
    if (onClearFilters) {
      onClearFilters();
    }
  };

  return (
    <div className="border-2 border-top border-bottom">
      <div className="pt-3">
        <button 
          onClick={() => setOpen(!open)}
          className="px-3 pt-2 w-100 text-start btn btn-light d-flex justify-content-between align-items-center"
        >
          <span className="fw-medium">Filters Menu</span>
          <i 
            className={`fa-solid fa-chevron-down transition-transform ${open ? 'rotate-180' : ''}`}
            style={{ transition: 'transform 0.3s' }}
          ></i>
        </button>
        
        {open && (
          <div className="px-2 py-3 border-top">
            <div className="px-3 py-4 px-md-4 px-lg-5 border-top bg-light">
              <form onSubmit={handleSubmit} className="row g-4">
                <div className={`row g-3 ${isAdmin ? 'row-cols-1 row-cols-lg-4' : 'row-cols-1 row-cols-sm-3'}`}>
                  
                  {/* Search */}
                  <div className="col">
                    <label className="mb-2 form-label fw-semibold text-dark">
                      <i className="fa-solid fa-search text-primary me-2"></i>
                      Search Projects
                    </label>
                    <input
                    id='search'
                      type="text"
                      className="form-control"
                      placeholder="Type name or description ..."
                      value={localSearch}
                      onChange={(e) => setLocalSearch(e.target.value)}
                    />
                  </div>

                  {/* Category Filter - ORA USA I DATI DAL CONTEXT */}
                  <div className="col">
                    <label className="mb-2 form-label fw-semibold text-dark">
                      <i className="fa-solid fa-folder text-purple me-2"></i>
                      Category
                      {loadingCategories && (
                        <span className="ms-2 spinner-border spinner-border-sm text-primary"></span>
                      )}
                    </label>
                    <select
                      className="form-select"
                      value={localCategory}
                      onChange={(e) => setLocalCategory(e.target.value)}
                      disabled={loadingCategories}
                    >
                      <option value="all">
                        All Categories {!loadingCategories && `(${categories.length})`}
                      </option>
                      
                      {loadingCategories ? (
                        <option value="" disabled>Loading categories...</option>
                      ) : categories.length === 0 ? (
                        <option value="" disabled>No categories available</option>
                      ) : (
                        categories.map((cat) => (
                          <option key={cat.id} value={cat.name}>
                            {cat.label}
                          </option>
                        ))
                      )}
                    </select>
                  </div>

                  {/* Technology Filter - ORA USA I DATI DAL CONTEXT */}
                  <div className="col">
                    <label className="mb-2 form-label fw-semibold text-dark">
                      <i className="fa-solid fa-code text-success me-2"></i>
                      Technology
                      {loadingTechnologies && (
                        <span className="ms-2 spinner-border spinner-border-sm text-success"></span>
                      )}
                    </label>
                    <select
                      className="form-select"
                      value={localTechnology}
                      onChange={(e) => setLocalTechnology(e.target.value)}
                      disabled={loadingTechnologies}
                    >
                      <option value="">
                        All Technologies {!loadingTechnologies && `(${technologies.length})`}
                      </option>
                      {loadingTechnologies ? (
                        <option value="" disabled>Loading technologies...</option>
                      ) : technologies.length === 0 ? (
                        <option value="" disabled>No technologies available</option>
                      ) : (
                        technologies.map((tech) => (
                          <option key={tech.id} value={tech.id}>
                            {tech.label || tech.name}
                          </option>
                        ))
                      )}
                    </select>
                  </div>

                  {/* Status Filter (Admin only) */}
                  {isAdmin && (
                    <div className="col">
                      <label className="mb-2 form-label fw-semibold text-dark">
                        <i className="fa-solid fa-flag text-warning me-2"></i>
                        Status
                      </label>
                      <select
                        className="form-select"
                        value={localPublished}
                        onChange={(e) => setLocalPublished(e.target.value)}
                      >
                        <option value="">All Status</option>
                        <option value="true">Published</option>
                        <option value="false">Drafts</option>
                      </select>
                    </div>
                  )}
                </div>

                {/* ... resto del form (sort e buttons) ... */}
                <div className="row g-3 align-items-center">
                  <div className="col-12 col-md-6">
                    <div className="row g-2">
                      <div className="col">
                        <select
                          className="form-select"
                          value={localSortBy}
                          onChange={(e) => setLocalSortBy(e.target.value)}
                        >
                          <option value="created_at">Sort by: Date</option>
                          <option value="title">Sort by: Title</option>
                          <option value="updated_at">Sort by: Updated</option>
                        </select>
                      </div>
                      <div className="col">
                        <select
                          className="form-select"
                          value={localSortOrder}
                          onChange={(e) => setLocalSortOrder(e.target.value)}
                        >
                          <option value="desc">Descending</option>
                          <option value="asc">Ascending</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div className="col-12 col-md-6">
                    <div className="row g-2">
                      <div className="col">
                        <button
                          type="submit"
                          className="gap-2 btn btn-success w-100 d-flex align-items-center justify-content-center"
                        >
                          <i className="fa-solid fa-filter"></i>
                          <span>Apply</span>
                        </button>
                      </div>
                      <div className="col">
                        <button
                          type="button"
                          onClick={handleClear}
                          className="gap-2 btn btn-danger w-100 d-flex align-items-center justify-content-center"
                        >
                          <i className="fa-solid fa-broom"></i>
                          <span>Clear</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default Filters ;