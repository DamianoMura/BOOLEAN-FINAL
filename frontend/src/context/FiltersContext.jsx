import  { createContext, useContext, useState, useEffect, useCallback } from 'react';
import axios from 'axios';

// Crea il Context
export const FiltersContext = createContext();

// Hook personalizzato per usare il context
export const useFilters = () => {
  const context = useContext(FiltersContext);
  return context;
};

// Provider Component
export const FiltersProvider = ({ children }) => {
  // state for categories
  const [categories, setCategories] = useState([]);
  const [loadingCategories, setLoadingCategories] = useState(true);
  
  // state for technologies
  const [technologies, setTechnologies] = useState([]);
  const [loadingTechnologies, setLoadingTechnologies] = useState(true);
  
  // state for filters
  const [filters, setFilters] = useState({
    search: '',
    category: 'all',
    technology: '',
    published: '',
    sort_by: 'created_at',
    sort_order: 'desc'
  });

  // Fetch categories
  const fetchCategories = useCallback(async () => {
    try {
      setLoadingCategories(true);
      const response = await axios.get('http://localhost:8000/api/categories');
      setCategories(response.data.categories || []);
    } catch (error) {
      console.error('Error fetching categories:', error);
      setCategories([]);
    } finally {
      setLoadingCategories(false);
    }
  }, []);

  // Fetch tecnologies
  const fetchTechnologies = useCallback(async () => {
    try {
      setLoadingTechnologies(true);
      const response = await axios.get('http://localhost:8000/api/technologies');
      setTechnologies(response.data.technologies || []);
    } catch (error) {
      console.error('Error fetching technologies:', error);
      setTechnologies([]);
    } finally {
      setLoadingTechnologies(false);
    }
  }, []);

  // load all at mounting
  useEffect(() => {
    fetchCategories();
    fetchTechnologies();
  }, [fetchCategories, fetchTechnologies]);

  // refresh filters
  const updateFilters = useCallback((newFilters) => {
  
    setFilters(prev => ({ ...prev, ...newFilters }));
  }, []);

  // reset filters
   const resetFilters = useCallback(() => {
    setFilters({
      search: '',
      category: 'all',
      technology: '',
      published: '',
      sort_by: 'created_at',
      sort_order: 'desc'
    });
  }, []);

  // context values
  const value = {
    categories,
    loadingCategories,
    technologies,
    loadingTechnologies,
    filters,
    updateFilters,
    resetFilters,
    refetchCategories: fetchCategories,
    refetchTechnologies: fetchTechnologies
  };

  

  return (
    <FiltersContext.Provider value={value}>
      {children}
    </FiltersContext.Provider>
  );
};