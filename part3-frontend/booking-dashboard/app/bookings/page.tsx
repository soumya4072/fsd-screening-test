"use client";

import { useEffect, useState } from "react";
import api from "../../../lib/api";
import { toast } from "react-hot-toast";

export default function BookingsPage() {
  const [bookings, setBookings] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    api.get("/bookings")
      .then(res => setBookings(res.data.data))
      .catch(() => toast.error("Failed to load bookings"))
      .finally(() => setLoading(false));
  }, []);

  if (loading) return <p>Loading...</p>;

  return (
    <div className="p-6">
      <h1 className="text-xl font-bold mb-4">Bookings</h1>

      <table className="w-full border">
        <thead>
          <tr>
            <th>Email</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          {bookings?.map((b: any) => (
            <tr key={b.id}>
              <td>{b.email}</td>
              <td>{b.status}</td>
              <td>{b.booking_date}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
