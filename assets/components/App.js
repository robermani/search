import React, { useState } from 'react';
import SearchForm from './SearchForm/SearchForm';
import SearchResults from './SearchResults/SearchResults';
import "./App.css";

const USE_DEMO_DATA = false;

const demoResults = {
  google: [
    { title: 'Demo Google Result 1', link: 'https://www.google.com' },
    { title: 'Demo Google Result 2', link: 'https://www.google.com' },
  ],
  bing: [
    { title: 'Demo Bing Result 1', link: 'https://www.bing.com' },
    { title: 'Demo Bing Result 2', link: 'https://www.bing.com' },
  ],
};

const App = () => {
  const [results, setResults] = useState([]);
  const [displayMode, setDisplayMode] = useState('list');
  const [hasSearched, setHasSearched] = useState(false);
  const [loading, setLoading] = useState(false); // Add loading state

  const handleSearch = async (query) => {
    if (query) {
      setLoading(true); // Set loading to true when search starts
      if (USE_DEMO_DATA) {
        const combinedResults = [...demoResults.google, ...demoResults.bing];
        setResults(combinedResults);
        setLoading(false); // Set loading to false when search ends
      } else {
        try {
          setHasSearched(true);
          const response = await fetch(`/api/search?q=${query}`);
          const data = await response.json();
          const combinedResults = [
            ...data.results.google,
            ...data.results.bing,
          ];
          setResults(combinedResults);
        } catch (error) {
          console.error('Error fetching search results', error);
        } finally {
          setLoading(false); // Set loading to false when search ends
        }
      }
    }
  };

  const handleDisplayModeChange = (e) => {
    setDisplayMode(e.target.value);
  };

  return (
      <div className="container">
        <h1 className="my-4">Search Page</h1>
        <SearchForm onSearch={handleSearch} loading={loading} /> {/* Pass loading state */}
        {
            loading &&
          <div className="spinner-border spinner" role="status">
            <span className="sr-only">Loading...</span>
          </div>
        } {/* Show loader */}
        {hasSearched && !loading && (
            <SearchResults
                results={results}
                displayMode={displayMode}
                onDisplayModeChange={handleDisplayModeChange}
            />
        )}
      </div>
  );
};

export default App;
