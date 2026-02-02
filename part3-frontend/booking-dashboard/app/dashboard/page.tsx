"use client";

import { useEffect, useState } from "react";
import api from "lib/api";
import { toast } from "react-hot-toast";
import { BarChart, Bar, XAxis, YAxis } from "recharts";

export default function Dashboard() {
  const [stats, setStats] = useState<any>(null);

  useEffect(() => {
    api.get("/analytics/bookings")
      .then(res => setStats(res.data))
      .catch(() => toast.error("Failed to load dashboard"));
  }, []);

  if (!stats) return <p>Loading...</p>;

  return (
    <div className="p-6 space-y-6">
      <h1 className="text-2xl font-bold">Dashboard</h1>

      {/* Stats */}
      <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div className="card">Total: {stats.total}</div>
        <div className="card">Pending: {stats.pending}</div>
        <div className="card">Confirmed: {stats.confirmed}</div>
        <div className="card">Cancelled: {stats.cancelled}</div>
      </div>

      {/* Chart */}
      <BarChart width={400} height={300} data={stats.chart}>
        <XAxis dataKey="date" />
        <YAxis />
        <Bar dataKey="count" />
      </BarChart>
    </div>
  );
}
