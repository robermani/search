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
  const [loading, setLoading] = useState(false);
  const [chunk, setChunk] = useState(1); // Add chunk state
  const [query, setQuery] = useState(''); // Add query state

  const handleSearch = async (searchQuery) => {
    if (searchQuery) {
      setLoading(true);
      setQuery(searchQuery); // Set the query state
      setChunk(1); // Reset chunk to 1 on new search
      if (USE_DEMO_DATA) {
        const combinedResults = [...demoResults.google, ...demoResults.bing];
        setResults(combinedResults);
        setLoading(false);
      } else {
        try {
          setHasSearched(true);
          const response = await fetch(`/api/search?q=${searchQuery}&chunk=1`);
          const data = await response.json();
          const combinedResults = [
            ...data.results.google,
            ...data.results.bing,
          ];
          setResults(combinedResults);
        } catch (error) {
          console.error('Error fetching search results', error);
        } finally {
          setLoading(false);
        }
      }
    }
  };

  const handleLoadMore = async () => {
    setLoading(true);
    const nextChunk = chunk + 1;
    setChunk(nextChunk);
    try {
      const response = await fetch(`/api/search?q=${query}&chunk=${nextChunk}`);
      const data = await response.json();
      const combinedResults = [
        ...results,
        ...data.results.google,
        ...data.results.bing,
      ];
      setResults(combinedResults);
    } catch (error) {
      console.error('Error fetching more search results', error);
    } finally {
      setLoading(false);
    }
  };

  const handleDisplayModeChange = (e) => {
    setDisplayMode(e.target.value);
  };

  return (
      <div className="container">
        <h1 className="my-4">Search Page</h1>
        <SearchForm onSearch={handleSearch} loading={loading} />
        {loading && (
            <div className="spinner-border spinner" role="status">
              <span className="sr-only">Loading...</span>
            </div>
        )}
        {hasSearched && !loading && (
            <SearchResults
                results={results}
                displayMode={displayMode}
                onDisplayModeChange={handleDisplayModeChange}
                onLoadMore={handleLoadMore} // Pass handleLoadMore to SearchResults
            />
        )}
      </div>
  );
};

export default App;
